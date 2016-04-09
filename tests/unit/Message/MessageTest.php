<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Message;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;

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
}
