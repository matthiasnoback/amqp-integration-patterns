<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles;

use AMQPIntegrationPatterns\MessageIsInvalid;
use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumerFailsBecauseMessageIsInvalid implements Consumer
{
    public $actualMessage;

    public function consume(AMQPMessage $amqpMessage)
    {
        $this->actualMessage = $amqpMessage;

        throw new MessageIsInvalid('This message is invalid');
    }
}
