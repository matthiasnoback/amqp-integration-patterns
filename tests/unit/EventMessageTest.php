<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\ContentType;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\MessageIdentifier;

class EventMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_an_identifier_a_content_type_and_a_body()
    {
        $body = new Body(new ContentType('text/plain'), 'body text');
        $messageIdentifier = MessageIdentifier::random();
        $eventMessage = EventMessage::create($messageIdentifier, $body);
        $this->assertEquals($messageIdentifier, $eventMessage->messageIdentifier());
        $this->assertEquals($body, $eventMessage->body());
    }
}
