<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

class ConsumeOneMessage implements Consumer
{
    /**
     * @var Consumer
     */
    private $consumer;

    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function consume(AMQPMessage $amqpMessage)
    {
        $this->consumer->consume($amqpMessage);

        throw new StopWaiting();
    }
}
