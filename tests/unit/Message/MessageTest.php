<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Message;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\Message\UndefinedMetadata;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_an_identifier_a_content_type_and_a_body()
    {
        $body = new Body(ContentType::fromString('text/plain'), 'body text');
        $messageIdentifier = MessageIdentifier::random();
        $message = Message::create($messageIdentifier, $body);
        $this->assertEquals($messageIdentifier, $message->messageIdentifier());
        $this->assertEquals($body, $message->body());
    }

    /**
     * @test
     */
    public function it_can_have_extra_metadata()
    {
        $body = new Body(ContentType::fromString('text/plain'), 'body text');
        $messageIdentifier = MessageIdentifier::random();
        $message = Message::create($messageIdentifier, $body);

        $message = $message->withMetadata('key', 'value');

        $this->assertEquals($messageIdentifier, $message->messageIdentifier());
        $this->assertEquals($body, $message->body());
        $this->assertEquals('value', $message->metadata('key'));
    }
    
    /**
     * @test
     */
    public function it_fails_if_provided_metadata_key_is_undefined()
    {
        $message = $this->simpleMessage();

        $this->setExpectedException(UndefinedMetadata::class, 'No metadata has been defined for key "key"');
        $message->metadata('key');
    }

    /**
     * @return Message
     */
    private function simpleMessage()
    {
        $body = new Body(ContentType::fromString('text/plain'), 'body text');
        $messageIdentifier = MessageIdentifier::random();
        $message = Message::create($messageIdentifier, $body);
        return $message;
    }
}
