<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Channel;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\Message;
use Assert\Assertion;
use PhpAmqpLib\Channel\AMQPChannel;

class AmqpMessageChannel implements Channel
{
    /**
     * @var AmqpMessageChannel
     */
    private $channel;

    /**
     * @var string
     */
    private $queueName;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var string
     */
    private $exchangeName;

    /**
     * @var string
     */
    private $routingKey;

    /**
     * @var bool
     */
    private $wait = false;

    public function __construct(AMQPChannel $channel, $queueName, $exchangeName, $routingKey, MessageFactory $messageFactory)
    {
        $this->channel = $channel;

        Assertion::string($queueName);
        $this->queueName = $queueName;

        Assertion::string($exchangeName);
        Assertion::notEmpty($exchangeName);
        $this->exchangeName = $exchangeName;

        Assertion::string($routingKey);
        $this->routingKey = $routingKey;

        $this->messageFactory = $messageFactory;
    }

    /**
     * @param EventMessage $message
     */
    public function publish(Message $message)
    {
        Assertion::isInstanceOf($message, EventMessage::class);

        $amqpMessage = $this->messageFactory->createAmqpMessageFromEventMessage($message);

        $this->channel->basic_publish($amqpMessage, $this->exchangeName, $this->routingKey);
    }

    public function waitForMessages(callable $callback)
    {
        $this->wait = true;

        $this->channel->basic_consume(
            $this->queueName,
            '', // consumer tag
            false, // no local
            false, // no ack
            false, // exclusive
            false, // no wait
            $callback
        );

        /*
         * @TODO think about the callback system
         */

        while(count($this->channel->callbacks)) {
            if (!$this->wait) {
                break;
            }
            $this->channel->wait();
        }
    }

    public function stopWaiting()
    {
        $this->wait = false;
    }
}
