<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

interface Consumer
{
    /**
     * @param AMQPMessage $amqpMessage
     */
    public function consume(AMQPMessage $amqpMessage);
}
