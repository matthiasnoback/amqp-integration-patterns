<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric\TestDoubles;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\StopConsuming;
use PhpAmqpLib\Message\AMQPMessage;

class SmartConsumerSpy implements Consumer
{
    /**
     * @var AMQPMessage[]
     */
    public $amqpMessages = [];

    public function consume(AMQPMessage $amqpMessage)
    {
        if (strpos($amqpMessage->body, 'fail') !== false) {
            throw new \Exception();
        }

        $this->amqpMessages[] = $amqpMessage;

        if (strpos($amqpMessage->body, 'stop') !== false) {
            throw new StopConsuming();
        }
    }
}
