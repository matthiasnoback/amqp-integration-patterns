<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization;

use AMQPIntegrationPatterns\ApplicationError;
use AMQPIntegrationPatterns\EndpointForReceiving;
use AMQPIntegrationPatterns\Serialization\Deserializer;
use AMQPIntegrationPatterns\Serialization\MessageReceiverDeserializesDataBeforeEndpointReceivesIt;
use AMQPIntegrationPatterns\Tests\Unit\Message\MessageFactory;

class MessageReceiverDeserializesDataBeforeEndpointReceivesItTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_deserializes_the_message_and_sends_it_to_a_message_receiver()
    {
        $deserializer = $this->prophesize(Deserializer::class);
        $message = MessageFactory::createMessageDummy();
        $data = new \stdClass();
        $deserializer->deserialize($message)->willReturn($data);

        $endpoint = $this->prophesize(EndpointForReceiving::class);
        $endpoint->accept($data, $message)->shouldBeCalled();

        $messageReceiver = new MessageReceiverDeserializesDataBeforeEndpointReceivesIt(
            $deserializer->reveal(),
            $endpoint->reveal()
        );

        $messageReceiver->receive($message);
    }

    /**
     * @test
     */
    public function it_turns_exceptions_into_application_errors()
    {
        $deserializer = $this->prophesize(Deserializer::class);
        $message = MessageFactory::createMessageDummy();
        $data = new \stdClass();
        $deserializer->deserialize($message)->willReturn($data);

        $exception = new \Exception('Something went wrong');
        $endpoint = $this->prophesize(EndpointForReceiving::class);
        $endpoint->accept($data, $message)->willThrow($exception);

        $messageReceiver = new MessageReceiverDeserializesDataBeforeEndpointReceivesIt(
            $deserializer->reveal(),
            $endpoint->reveal()
        );

        try {
            $messageReceiver->receive($message);

            $this->fail('Expected an exception to be thrown');
        } catch (\Exception $actualException) {
            $this->assertInstanceOf(ApplicationError::class, $actualException);
            $this->assertSame($exception, $actualException->getPrevious());
        }
    }
}
