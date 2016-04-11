<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredExchange;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\MessageSender;

final class AmqpMessageSender implements MessageSender
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var DeclaredExchange
     */
    private $exchange;

    private $routingKey;

    public function __construct(
        DeclaredExchange $exchange,
        $routingKey,
        MessageFactory $messageFactory
    ) {
        $this->exchange = $exchange;
        $this->routingKey = $routingKey;
        $this->messageFactory = $messageFactory;
    }

    public function send(Message $message)
    {
        $amqpMessage = $this->messageFactory->createAmqpMessageFromMessage($message);

        $this->exchange->publish($amqpMessage, $this->routingKey);
    }
}
