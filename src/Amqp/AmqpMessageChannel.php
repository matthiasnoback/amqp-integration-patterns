<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredExchange;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\MessageChannel;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\MessageSender;

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

    public function send(Message $message)
    {
        $amqpMessage = $this->messageFactory->createAmqpMessageFromMessage($message);

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
