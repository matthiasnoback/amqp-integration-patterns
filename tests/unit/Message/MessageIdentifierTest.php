<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Message;

use AMQPIntegrationPatterns\Message\MessageIdentifier;
use Ramsey\Uuid\Uuid;

class MessageIdentifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_represents_a_textual_identifier()
    {
        $textualIdentifier = 'textual identifier';
        $messageIdentifier = new MessageIdentifier($textualIdentifier);
        $this->assertSame($textualIdentifier, (string) $messageIdentifier);
    }

    /**
     * @test
     */
    public function it_can_generate_a_unique_identifier_for_itself()
    {
        $messageIdentifier = MessageIdentifier::random();

        $this->assertTrue(Uuid::isValid((string) $messageIdentifier));
    }
}
