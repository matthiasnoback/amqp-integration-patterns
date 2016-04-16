<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\EventDrivenConsumer;
use Assert\Assertion;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeMaximumAmount implements Consumer
{
    /**
     * @var Consumer
     */
    private $consumer;

    /**
     * @var integer
     */
    private $maximumAmount;

    /**
     * @var integer
     */
    private $consumedAmount = 0;

    public function __construct(Consumer $consumer, $maximumAmount)
    {
        Assertion::integer($maximumAmount);

        $this->consumer = $consumer;
        $this->maximumAmount = $maximumAmount;
    }

    public function consume(AMQPMessage $amqpMessage, EventDrivenConsumer $eventDrivenConsumer)
    {
        if ($this->consumedAmount >= $this->maximumAmount) {
            throw new \LogicException('The maximum amount of messages has been consumed');
        }

        $this->consumer->consume($amqpMessage, $eventDrivenConsumer);

        $this->consumedAmount++;

        if ($this->consumedAmount >= $this->maximumAmount) {
            $eventDrivenConsumer->stopWaiting();
        }
    }
}
