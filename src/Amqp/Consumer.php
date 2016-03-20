<?php

namespace AMQPIntegrationPatterns\Amqp;

use PhpAmqpLib\Message\AMQPMessage;

interface Consumer
{
    /**
     * @return ConsumptionFlag
     */
    public function consume(AMQPMessage $amqpMessage);
}
