<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Producer;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use AMQPIntegrationPatterns\MessageIsInvalid;
use PhpAmqpLib\Message\AMQPMessage;

final class PublishInvalidMessageToInvalidMessageChannel implements Consumer
{
    /**
     * @var Consumer
     */
    private $nextConsumer;

    /**
     * @var Producer
     */
    private $invalidMessageProducer;

    public function __construct(Consumer $nextConsumer, Producer $invalidMessageProducer)
    {
        $this->nextConsumer = $nextConsumer;
        $this->invalidMessageProducer = $invalidMessageProducer;
    }

    public function consume(AMQPMessage $amqpMessage, EventDrivenConsumer $eventDrivenConsumer)
    {
        try {
            $this->nextConsumer->consume($amqpMessage, $eventDrivenConsumer);
        } catch (MessageIsInvalid $exception) {
            $this->invalidMessageProducer->publish($amqpMessage);

            throw $exception;
        }
    }
}
