<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp;

use AMQPIntegrationPatterns\Amqp\MessageFactory;
use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\MessageIdentifier;
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
        $bodyText = 'body text';
        $amqpMessage->setBody($bodyText);

        $eventMessage = $this->messageFactory->createEventMessageFrom($amqpMessage);
        $this->assertEquals(new MessageIdentifier($messageId), $eventMessage->messageIdentifier());
        $this->assertEquals(new Body($bodyText), $eventMessage->body());
    }

    /**
     * @test
     */
    public function it_fails_when_the_amqp_message_has_no_message_identifier()
    {
        $this->setExpectedException(MessageIsInvalid::class);
        $this->messageFactory->createEventMessageFrom(new AMQPMessage());
    }
}
