<?php


namespace AMQPIntegrationPatterns\Tests\Unit;


use AMQPIntegrationPatterns\MessageTranslator;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\ChannelMock;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\MessageDummy;
use AMQPIntegrationPatterns\Tests\Unit\TestDoubles\TranslatorStub;

class MessageTranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_translates_a_message_before_sending_it_to_the_designated_channel()
    {
        $message = new MessageDummy();
        $channel = new ChannelMock();

        $translatedMessage = new MessageDummy();
        $translator = new TranslatorStub($translatedMessage);

        $messageTranslator = new MessageTranslator($translator, $channel);
        $messageTranslator->process($message);

        $this->assertSame($message, $translator->actualMessage);
        $this->assertSame($translatedMessage, $channel->actualMessage);
    }
}
