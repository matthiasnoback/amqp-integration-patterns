<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric\TestDoubles;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumerSpy implements Consumer
{
    /**
     * @var AMQPMessage
     */
    public $amqpMessage;

    public function consume(AMQPMessage $amqpMessage, EventDrivenConsumer $eventDrivenConsumer)
    {
        $this->amqpMessage = $amqpMessage;

        $eventDrivenConsumer->stopWaiting();
    }
}
