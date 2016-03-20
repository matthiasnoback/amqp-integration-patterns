<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles;

use AMQPIntegrationPatterns\Amqp\Consumer;
use AMQPIntegrationPatterns\Amqp\ConsumptionFlag;
use PhpAmqpLib\Message\AMQPMessage;

class AlwaysSucceedingConsumer implements Consumer
{
    public $actualMessage;

    public function consume(AMQPMessage $amqpMessage)
    {
        $this->actualMessage = $amqpMessage;

        return ConsumptionFlag::acknowledge();
    }
}
