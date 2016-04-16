<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\EventDrivenConsumer;
use PhpAmqpLib\Message\AMQPMessage;

interface Consumer
{
    /**
     * @param AMQPMessage $amqpMessage
     * @param EventDrivenConsumer $eventDrivenConsumer
     * @return void
     */
    public function consume(AMQPMessage $amqpMessage, EventDrivenConsumer $eventDrivenConsumer);
}
