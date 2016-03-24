<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class QueueConsumer
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

    public function __construct(AMQPChannel $channel, DeclaredQueue $queue, callable $callback)
    {
        $this->channel = $channel;
        $this->queue = $queue;
        $this->callback = $callback;
    }

    public function wait()
    {
        $this->wait = true;

        $this->channel->basic_consume(
            (string) $this->queue->name(),
            '', // consumer tag TODO provide unique value for this
            false, // no local
            false, // no ack
            false, // exclusive
            false, // no wait
            function (AMQPMessage $message) {
                call_user_func_array($this->callback, [$message, $this]);
            }
        );

        while(count($this->channel->callbacks)) {
            if (!$this->wait) {
                break;
            }

            $this->channel->wait();
        }
    }

    public function stopWaiting()
    {
        $this->wait = false;
    }
}
