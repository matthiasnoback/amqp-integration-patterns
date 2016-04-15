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
            (string)$this->processIdentifier, // consumer tag
            false, // no local
            false, // no ack
            false, // exclusive
            false, // no wait
            function (AMQPMessage $amqpMessage) {
                try {
                    $this->consumer->consume($amqpMessage);
                } catch (StopConsuming $exception) {
                    $this->wait = false;
                }

                // TODO implement ack/nack etc. (in consumer)
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
            (string)$this->processIdentifier,
            false, // no wait
            false // no return
        );
    }
}
