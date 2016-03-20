<?php

namespace AMQPIntegrationPatterns\Amqp;

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

    public function consume(AMQPMessage $amqpMessage)
    {
        try {
            return $this->nextConsumer->consume($amqpMessage);
        } catch (MessageIsInvalid $exception) {
            $this->invalidMessageProducer->publish($amqpMessage);

            return ConsumptionFlag::reject();
        }
    }
}
