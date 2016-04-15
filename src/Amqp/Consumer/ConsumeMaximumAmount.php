<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

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

    public function consume(AMQPMessage $amqpMessage)
    {
        $consumptionFlag = $this->consumer->consume($amqpMessage);

        $this->consumedAmount++;

        if ($this->consumedAmount >= $this->maximumAmount) {
            throw new StopConsuming();
        }

        return $consumptionFlag;
    }
}
