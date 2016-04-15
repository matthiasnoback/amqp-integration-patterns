<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\StopConsuming;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use AMQPIntegrationPatterns\ProcessIdentifier;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

final class QueueConsumer implements EventDrivenConsumer
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var DeclaredQueue
     */
    private $queue;

    private $wait = false;

    /**
     * @var ProcessIdentifier
     */
    private $processIdentifier;

    /**
     * @var Consumer
     */
    private $consumer;

    public function __construct(
        AMQPChannel $channel,
        ProcessIdentifier $processIdentifier,
        DeclaredQueue $queue,
        Consumer $consumer
    ) {
        $this->channel = $channel;
        $this->queue = $queue;
        $this->processIdentifier = $processIdentifier;
        $this->consumer = $consumer;
    }

    public function wait()
    {
        $this->wait = true;

        $this->channel->basic_consume(
            (string)$this->queue->name(),
            $this->consumerTag(),
            false, // no local
            false, // no ack
            false, // exclusive
            false, // no wait
            function (AMQPMessage $amqpMessage) {
                try {
                    $this->consumer->consume($amqpMessage);

                    $this->acknowledge($amqpMessage);
                } catch (StopConsuming $exception) {
                    $this->stopWaiting();
                    $this->acknowledge($amqpMessage); // TODO see if there is a better solution
                } catch (\Exception $exception) {
                    $this->channel->basic_reject(
                        $amqpMessage->delivery_info['delivery_tag'],
                        false
                    );
                }
            }
        );

        while (count($this->channel->callbacks)) {
            if (!$this->wait) {
                $this->stopConsuming();

                break;
            }

            // TODO configure a timeout
            $this->channel->wait(null, false, 3);
        }
    }

    public function stopWaiting()
    {
        $this->wait = false;
    }

    private function stopConsuming()
    {
        $this->channel->basic_cancel(
            $this->consumerTag(),
            false, // no wait
            false // no return
        );
    }

    private function consumerTag()
    {
        return (string)$this->processIdentifier;
    }

    private function acknowledge(AMQPMessage $amqpMessage)
    {
        $this->channel->basic_ack(
            $amqpMessage->delivery_info['delivery_tag'],
            false
        );
    }
}
