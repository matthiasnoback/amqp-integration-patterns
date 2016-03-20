<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\MessageIdentifier;

class EventMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_an_identifier_and_a_body()
    {
        $body = new Body('body text');
        $messageIdentifier = MessageIdentifier::random();
        $eventMessage = EventMessage::create($messageIdentifier, $body);
        $this->assertEquals($messageIdentifier, $eventMessage->messageIdentifier());
        $this->assertEquals($body, $eventMessage->body());
    }
}
