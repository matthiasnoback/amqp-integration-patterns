<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\ContentType;
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
        return EventMessage::create(
            $this->extractMessageIdentifierFrom($amqpMessage),
            $this->extractBody($amqpMessage)
        );
    }

    public function extractMessageIdentifierFrom(AMQPMessage $amqpMessage)
    {
        try {
            return new MessageIdentifier($amqpMessage->get('message_id'));
        } catch (\Exception $exception) {
            throw new MessageIsInvalid('Invalid message identifier', $exception);
        }
    }

    public function extractContentTypeFrom(AMQPMessage $amqpMessage)
    {
        try {
            return ContentType::fromString($amqpMessage->get('content_type'));
        } catch (\Exception $exception) {
            throw new MessageIsInvalid('Invalid content type', $exception);
        }
    }

    public function extractBody(AMQPMessage $amqpMessage)
    {
        $contentType = $this->extractContentTypeFrom($amqpMessage);

        try {
            return new Body($contentType, $amqpMessage->body);
        } catch (\Exception $exception) {
            throw new MessageIsInvalid('Invalid body', $exception);
        }
    }

    /**
     * @param EventMessage $message
     * @return AMQPMessage
     */
    public function createAmqpMessageFromEventMessage(EventMessage $message)
    {
        $amqpMessage = new AMQPMessage();
        $amqpMessage->body = (string) $message->body();
        $amqpMessage->set('content_type', (string) $message->body()->contentType());
        $amqpMessage->set('message_id', (string) $message->messageIdentifier());
        $amqpMessage->set('delivery_mode', 2);

        return $amqpMessage;
    }
}
