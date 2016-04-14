<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\ConsumptionFlag;
use PhpAmqpLib\Message\AMQPMessage;

interface Consumer
{
    /**
     * @param AMQPMessage $amqpMessage
     * @return ConsumptionFlag TODO enforce this everywhere
     */
    public function consume(AMQPMessage $amqpMessage);
}
