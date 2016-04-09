<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Message;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;

class BodyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_a_body_text_with_a_content_type()
    {
        $bodyText = 'some text';
        $contentType = ContentType::fromString('plain/text');
        $body = new Body($contentType, $bodyText);
        $this->assertSame($bodyText, (string) $body);
        $this->assertEquals($contentType, $body->contentType());
    }
}
