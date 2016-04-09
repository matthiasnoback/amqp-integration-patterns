<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredExchange;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\MessageChannel;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\MessageSender;
use Assert\Assertion;

final class AmqpMessageChannel implements MessageChannel, MessageSender
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var DeclaredExchange
     */
    private $exchange;

    /**
     * @var DeclaredQueue
     */
    private $queue;

    private $routingKey;

    public function __construct(
        DeclaredExchange $exchange,
        DeclaredQueue $queue,
        $routingKey,
        MessageFactory $messageFactory
    ) {
        $this->exchange = $exchange;
        $this->queue = $queue;
        $this->routingKey = $routingKey;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param EventMessage $message
     */
    public function send(Message $message)
    {
        // TODO move this logic to the message factory (should be an abstract factory)
        Assertion::isInstanceOf($message, EventMessage::class);

        $amqpMessage = $this->messageFactory->createAmqpMessageFromEventMessage($message);

        $this->exchange->publish($amqpMessage, $this->routingKey);
    }

    public function waitForMessages(callable $callback)
    {
        $this->queue->consume($callback)->wait();
    }

    public function purge()
    {
        $this->queue->purge();
    }
}
