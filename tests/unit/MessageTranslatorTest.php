<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\MessageTranslator;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\MessageSenderMock;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\TranslatorStub;

class MessageTranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_translates_a_message_before_sending_it_to_the_designated_channel()
    {
        $message = $this->messageDummy();
        $messageSender = new MessageSenderMock();

        $translatedMessage = $this->messageDummy();
        $translator = new TranslatorStub($translatedMessage);

        $messageTranslator = new MessageTranslator($translator, $messageSender);
        $messageTranslator->consume($message);

        $this->assertSame($message, $translator->actualMessage);
        $this->assertSame($translatedMessage, $messageSender->actualMessage);
    }

    /**
     * @return Message
     */
    private function messageDummy()
    {
        return Message::create(
            MessageIdentifier::random(),
            new Body(ContentType::json(), '')
        );
    }
}
