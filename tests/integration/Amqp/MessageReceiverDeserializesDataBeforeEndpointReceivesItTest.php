<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\Amqp\Consumer\ConsumeMaximumAmount;
use AMQPIntegrationPatterns\Amqp\Consumer\ForwardToMessageReceiver;
use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use AMQPIntegrationPatterns\Amqp\GenericMessageFactory;
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
use PhpAmqpLib\Message\AMQPMessage;

class MessageReceiverDeserializesDataBeforeEndpointReceivesItTest extends \PHPUnit_Framework_TestCase
{
    use AmqpTestHelper;

    /**
     * @test
     */
    public function it_produces_an_object_based_on_a_message()
    {
        $expectedMessage = Message::create(
            new MessageIdentifier('1234'),
            new Body(ContentType::json(), '{"field":"the value"}')
        );

        $expectedObject = new DenormalizableObject('the value');

        $endpoint = $this->endpointShouldAcceptObject($expectedObject, $expectedMessage);

        $messageReceiver = new MessageReceiverDeserializesDataBeforeEndpointReceivesIt(
            new DecodeAndDenormalizeObjectDeserializer(
                new JsonEncoder(),
                new SimpleNormalizer(),
                DenormalizableObject::class
            ),
            $endpoint
        );

        $declaredExchange = ExchangeBuilder::create($this->getAmqpChannel(), 'events')
            ->declareExchange();

        $declaredQueue = $declaredExchange
            ->buildQueue('events_of_specific_type')
            ->withBinding('events_of_specific_type')
            ->declareQueue();
        $declaredQueue->purge();

        $amqpMessage = new AMQPMessage('{"field":"the value"}');
        $amqpMessage->set('message_id', '1234');
        $amqpMessage->set('content_type', 'application/json');
        $declaredExchange->publish($amqpMessage, 'events_of_specific_type');

        $amqpMessageConsumer = $declaredQueue->consume(
            new ConsumeMaximumAmount(
                new ForwardToMessageReceiver(
                    new GenericMessageFactory(),
                    $messageReceiver
                ),
                1
            )
        );
        $amqpMessageConsumer->wait();
    }

    /**
     * @param $expectedObject
     * @param Message $message
     * @return EndpointForReceiving|\PHPUnit_Framework_MockObject_MockObject
     */
    private function endpointShouldAcceptObject($expectedObject, Message $message)
    {
        $endpoint = $this->getMock(EndpointForReceiving::class);
        $endpoint->expects($this->once())
            ->method('accept')
            ->with($this->equalTo($expectedObject), $this->equalTo($message));

        return $endpoint;
    }
}
