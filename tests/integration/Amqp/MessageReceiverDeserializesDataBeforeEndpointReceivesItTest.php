<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\EndpointForReceiving;
use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\Serialization\DecodeAndDenormalizeObjectDeserializer;
use AMQPIntegrationPatterns\Serialization\Encoding\Json\JsonEncoder;
use AMQPIntegrationPatterns\Serialization\MessageReceiverDeserializesDataBeforeEndpointReceivesIt;
use AMQPIntegrationPatterns\Serialization\Normalization\SimpleNormalizer;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\TestDoubles\DenormalizableObject;

class MessageReceiverDeserializesDataBeforeEndpointReceivesItTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_produces_an_object_based_on_a_message()
    {
        $message = Message::create(
            MessageIdentifier::random(),
            new Body(ContentType::json(), '{"field":"the value"}')
        );

        $expectedObject = new DenormalizableObject('the value');

        $endpoint = $this->endpointShouldAcceptObject($expectedObject);

        $messageReceiver = new MessageReceiverDeserializesDataBeforeEndpointReceivesIt(
            new DecodeAndDenormalizeObjectDeserializer(
                new JsonEncoder(),
                new SimpleNormalizer(),
                DenormalizableObject::class
            ),
            $endpoint
        );

        $messageReceiver->receive($message);
    }

    /**
     * @param $expectedObject
     * @return \PHPUnit_Framework_MockObject_MockObject|EndpointForReceiving
     */
    private function endpointShouldAcceptObject($expectedObject)
    {
        $endpoint = $this->getMock(EndpointForReceiving::class);
        $endpoint->expects($this->once())
            ->method('accept')
            ->with($this->equalTo($expectedObject));
        return $endpoint;
    }
}
