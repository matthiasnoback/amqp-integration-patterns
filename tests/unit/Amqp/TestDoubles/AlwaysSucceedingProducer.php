<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles;

use AMQPIntegrationPatterns\Amqp\Producer;
use PhpAmqpLib\Message\AMQPMessage;

class AlwaysSucceedingProducer implements Producer
{
    public $actualMessage;

    public function publish(AMQPMessage $message)
    {
        $this->actualMessage = $message;
    }
}
