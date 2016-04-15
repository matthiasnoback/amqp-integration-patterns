<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer\ForwardToMessageReceiver;
use AMQPIntegrationPatterns\Amqp\ConsumptionFlag;
use AMQPIntegrationPatterns\Amqp\MessageFactory;
use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\MessageReceiver;
use PhpAmqpLib\Message\AMQPMessage;

class ForwardToMessageReceiverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_creates_a_standardized_message_from_the_amqp_message_and_forwards_it_to_the_message_receiver()
    {
        $amqpMessage = new AMQPMessage();
        $message = Message::create(MessageIdentifier::random(), new Body(ContentType::plainText(), ''));

        $messageFactory = $this->prophesize(MessageFactory::class);
        $messageFactory->createMessageFrom($amqpMessage)->willReturn($message);

        $messageReceiver = $this->prophesize(MessageReceiver::class);
        $messageReceiver->receive($message)->shouldBeCalled();
        
        $consumer = new ForwardToMessageReceiver(
            $messageFactory->reveal(),
            $messageReceiver->reveal()
        );

        $consumptionFlag = $consumer->consume($amqpMessage);

        $this->assertEquals(ConsumptionFlag::acknowledge(), $consumptionFlag);
    }
}
