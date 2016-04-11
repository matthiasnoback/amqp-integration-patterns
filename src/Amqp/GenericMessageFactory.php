<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\MessageIsInvalid;
use PhpAmqpLib\Message\AMQPMessage;

final class GenericMessageFactory implements MessageFactory
{
    public function createMessageFrom(AMQPMessage $amqpMessage)
    {
        return Message::create(
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

    public function createAmqpMessageFromMessage(Message $message)
    {
        $amqpMessage = new AMQPMessage();
        $amqpMessage->body = (string) $message->body();
        $amqpMessage->set('content_type', (string) $message->body()->contentType());
        $amqpMessage->set('message_id', (string) $message->messageIdentifier());
        $amqpMessage->set('delivery_mode', 2);

        return $amqpMessage;
    }
}
