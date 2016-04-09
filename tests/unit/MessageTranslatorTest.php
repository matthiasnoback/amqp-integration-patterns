<?php


namespace AMQPIntegrationPatterns\Tests\Unit;


use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\MessageTranslator;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\MessageChannelMock;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\TranslatorStub;

class MessageTranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_translates_a_message_before_sending_it_to_the_designated_channel()
    {
        $message = $this->messageDummy();
        $channel = new MessageChannelMock();

        $translatedMessage = $this->messageDummy();
        $translator = new TranslatorStub($translatedMessage);

        $messageTranslator = new MessageTranslator($translator, $channel);
        $messageTranslator->consume($message);

        $this->assertSame($message, $translator->actualMessage);
        $this->assertSame($translatedMessage, $channel->actualMessage);
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
