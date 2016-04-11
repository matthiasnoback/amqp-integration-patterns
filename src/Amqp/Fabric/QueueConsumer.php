<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

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

    /**
     * @var callable
     */
    private $callback;

    private $wait = false;

    /**
     * @var ProcessIdentifier
     */
    private $processIdentifier;

    public function __construct(
        AMQPChannel $channel,
        ProcessIdentifier $processIdentifier,
        DeclaredQueue $queue,
        callable $callback
    ) {
        $this->channel = $channel;
        $this->queue = $queue;
        $this->callback = $callback;
        $this->processIdentifier = $processIdentifier;
    }

    public function waitForMessage()
    {
        $this->wait = true;

        $this->channel->basic_consume(
            (string)$this->queue->name(),
            (string)$this->processIdentifier, // consumer tag
            false, // no local
            false, // no ack
            false, // exclusive
            false, // no wait
            function (AMQPMessage $message) {
                call_user_func_array($this->callback, [$message, $this]);
            }
        );
        // TODO implement ack/nack etc. (in consumer)

        while (count($this->channel->callbacks)) {
            if (!$this->wait) {
                $this->channel->basic_cancel(
                    (string)$this->processIdentifier,
                    false, // no wait
                    false // no return
                );

                break;
            }

            // TODO configure a timeout
            $this->channel->wait();
        }
    }

    public function stopWaiting()
    {
        $this->wait = false;
    }
}
