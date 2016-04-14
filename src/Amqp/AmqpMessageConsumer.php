<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\EventDrivenConsumer;

class AmqpMessageConsumer implements EventDrivenConsumer
{
    /**
     * @var DeclaredQueue
     */
    private $declaredQueue;

    /**
     * @var Consumer
     */
    private $consumer;

    public function __construct(DeclaredQueue $declaredQueue, Consumer $consumer)
    {
        $this->declaredQueue = $declaredQueue;
        $this->consumer = $consumer;
    }

    public function wait()
    {
        $this->declaredQueue->consume($this->consumer)->wait();
    }

    public function stopWaiting()
    {
    }
}
