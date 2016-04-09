<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp;

use AMQPIntegrationPatterns\Amqp\MessageFactory;
use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\MessageIsInvalid;
use PhpAmqpLib\Message\AMQPMessage;
use Ramsey\Uuid\Uuid;

class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    protected function setUp()
    {
        $this->messageFactory = new MessageFactory();
    }

    /**
     * @test
     */
    public function it_creates_an_event_message_for_a_given_amqp_message()
    {
        $amqpMessage = new AMQPMessage();
        $messageId = (string)Uuid::uuid4();
        $amqpMessage->set('message_id', $messageId);
        $contentType = 'text/plain';
        $amqpMessage->set('content_type', $contentType);
        $bodyText = 'body text';
        $amqpMessage->setBody($bodyText);

        $eventMessage = $this->messageFactory->createEventMessageFrom($amqpMessage);
        $this->assertEquals(new MessageIdentifier($messageId), $eventMessage->messageIdentifier());
        $this->assertEquals(new Body(ContentType::fromString($contentType), $bodyText), $eventMessage->body());
    }

    /**
     * @test
     */
    public function it_fails_when_the_amqp_message_has_no_message_identifier()
    {
        $this->setExpectedException(MessageIsInvalid::class, 'Invalid message identifier');
        $this->messageFactory->extractMessageIdentifierFrom(new AMQPMessage());
    }

    /**
     * @test
     */
    public function it_fails_when_the_amqp_message_has_no_content_type()
    {
        $this->setExpectedException(MessageIsInvalid::class, 'Invalid content type');
        $this->messageFactory->extractContentTypeFrom(new AMQPMessage());
    }

    /**
     * @test
     */
    public function it_fails_when_the_amqp_message_has_no_body()
    {
        $message = new AMQPMessage();
        $message->set('content_type', 'text/plain');
        $message->body = null;

        $this->setExpectedException(MessageIsInvalid::class, 'Invalid body');
        $this->messageFactory->extractBody($message);
    }

    /**
     * @test
     */
    public function it_creates_an_amqp_message_for_an_event_message()
    {
        $bodyText = '{"message":"Hello"}';
        $contentType = 'application/json';
        $messageIdentifier = MessageIdentifier::random();
        $eventMessage = EventMessage::create(
            $messageIdentifier,
            new Body(ContentType::fromString($contentType), $bodyText)
        );

        $amqpMessage = $this->messageFactory->createAmqpMessageFromEventMessage($eventMessage);
        $this->assertSame($bodyText, $amqpMessage->body);
        $this->assertSame($contentType, $amqpMessage->get('content_type'));
        $this->assertSame((string) $messageIdentifier, $amqpMessage->get('message_id'));
        $this->assertSame(2, $amqpMessage->get('delivery_mode'));
    }
}
