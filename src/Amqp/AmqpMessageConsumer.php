<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Amqp\Fabric\QueueConsumer;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use PhpAmqpLib\Message\AMQPMessage;

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

    public function __construct(
        DeclaredQueue $declaredQueue,
        Consumer $consumer
    ) {
        $this->declaredQueue = $declaredQueue;
        $this->consumer = $consumer;
    }

    public function waitForMessage()
    {
        $callback = function (AMQPMessage $amqpMessage, QueueConsumer $queueConsumer) {
            $this->consumer->consume($amqpMessage);
            $queueConsumer->stopWaiting();
        };

        $this->declaredQueue->consume($callback)->waitForMessage();
    }

    public function stopWaiting()
    {
    }
}
