<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\Body;

class BodyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_a_body_text()
    {
        $bodyText = 'some text';
        $body = new Body($bodyText);
        $this->assertSame($bodyText, (string) $body);
    }

    /**
     * @test
     */
    public function it_can_be_empty()
    {
        $this->assertSame('', (string) Body::emptyBody());
    }
}
