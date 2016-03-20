<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\MessageIdentifier;
use AMQPIntegrationPatterns\MessageIsInvalid;
use PhpAmqpLib\Message\AMQPMessage;

class MessageFactory
{
    /**
     * @return EventMessage
     */
    public function createEventMessageFrom(AMQPMessage $amqpMessage)
    {
        try {
            $messageIdentifier = new MessageIdentifier($amqpMessage->get('message_id'));
        } catch (\Exception $exception) {
            throw new MessageIsInvalid('Invalid message identifier', $exception);
        }

        $body = new Body($amqpMessage->body);

        return EventMessage::create($messageIdentifier, $body);
    }
}
