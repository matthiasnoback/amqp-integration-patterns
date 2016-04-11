<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Message\Message;
use PhpAmqpLib\Message\AMQPMessage;

interface MessageFactory
{
    /**
     * @param AMQPMessage $amqpMessage
     * @return Message
     */
    public function createMessageFrom(AMQPMessage $amqpMessage);

    /**
     * @param Message $message
     * @return AMQPMessage
     */
    public function createAmqpMessageFromMessage(Message $message);
}
