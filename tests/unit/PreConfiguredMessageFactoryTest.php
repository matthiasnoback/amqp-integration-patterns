<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\ContentType;
use AMQPIntegrationPatterns\MessageIdentifier;
use AMQPIntegrationPatterns\PreConfiguredMessageFactory;

class PreConfiguredMessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_creates_a_message_with_the_pre_configured_content_type()
    {
        $messageFactory = new PreConfiguredMessageFactory(new ContentType('application/json'));
        $body = '{"message":"Hello world"}';
        $message = $messageFactory->createMessageWithBody($body);

        $this->assertEquals(new Body(new ContentType('application/json'), $body), $message->body());
        $this->assertTrue($message->messageIdentifier() instanceof MessageIdentifier);
    }
}
