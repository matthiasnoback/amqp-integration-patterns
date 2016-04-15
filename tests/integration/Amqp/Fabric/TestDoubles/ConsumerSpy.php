<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric\TestDoubles;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\StopConsuming;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumerSpy implements Consumer
{
    /**
     * @var AMQPMessage
     */
    public $amqpMessage;

    public function consume(AMQPMessage $amqpMessage)
    {
        $this->amqpMessage = $amqpMessage;

        throw new StopConsuming();
    }
}
