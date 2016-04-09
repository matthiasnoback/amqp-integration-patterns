<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Amqp\Fabric\QueueConsumer;
use AMQPIntegrationPatterns\MessageReceiver;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpMessageConsumer
{
    /**
     * @var DeclaredQueue
     */
    private $declaredQueue;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var MessageReceiver
     */
    private $messageReceiver;

    public function __construct(
        DeclaredQueue $declaredQueue,
        MessageFactory $messageFactory,
        MessageReceiver $messageReceiver
    ) {
        $this->declaredQueue = $declaredQueue;
        $this->messageFactory = $messageFactory;
        $this->messageReceiver = $messageReceiver;
    }

    public function consumeOneMessage()
    {
        $callback = function (AMQPMessage $message, QueueConsumer $queueConsumer) {
            $this->processMessage($message);
            $queueConsumer->stopWaiting();
        };

        $this->declaredQueue->consume($callback)->wait();
    }

    private function processMessage(AMQPMessage $amqpMessage)
    {
        $message = $this->messageFactory->createMessageFrom($amqpMessage);

        $this->messageReceiver->receive($message);
    }
}
