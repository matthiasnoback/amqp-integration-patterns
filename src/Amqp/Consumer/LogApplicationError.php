<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

class LogApplicationError implements Consumer
{
    public function consume(AMQPMessage $amqpMessage)
    {
        // TODO implement
    }
}
