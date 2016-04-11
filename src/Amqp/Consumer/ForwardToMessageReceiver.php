<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer;
use AMQPIntegrationPatterns\Amqp\MessageFactory;
use AMQPIntegrationPatterns\MessageReceiver;
use PhpAmqpLib\Message\AMQPMessage;

class ForwardToMessageReceiver implements Consumer
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var MessageReceiver
     */
    private $messageReceiver;

    public function __construct(MessageFactory $messageFactory, MessageReceiver $messageReceiver)
    {
        $this->messageFactory = $messageFactory;
        $this->messageReceiver = $messageReceiver;
    }

    public function consume(AMQPMessage $amqpMessage)
    {
        $message = $this->messageFactory->createMessageFrom($amqpMessage);

        $this->messageReceiver->receive($message);
    }
}
