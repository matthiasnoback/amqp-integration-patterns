<?php

namespace AMQPIntegrationPatterns\Amqp;

use PhpAmqpLib\Message\AMQPMessage;

interface Consumer
{
    /**
     * @param AMQPMessage $amqpMessage
     * @return ConsumptionFlag
     */
    public function consume(AMQPMessage $amqpMessage);
}
