<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\Amqp\AmqpMessageSender;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredExchange;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use AMQPIntegrationPatterns\Amqp\GenericMessageFactory;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\PreConfiguredMessageFactory;
use AMQPIntegrationPatterns\Serialization\EndpointSerializesDataBeforeSending;
use AMQPIntegrationPatterns\Serialization\Encoding\Json\JsonEncoder;
use AMQPIntegrationPatterns\Serialization\NormalizeAndEncodeObjectSerializer;
use AMQPIntegrationPatterns\Serialization\Normalization\SimpleNormalizer;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\TestDoubles\NormalizableObject;
use Ramsey\Uuid\Uuid;

class EndpointSerializesDataBeforeSendingTest extends \PHPUnit_Framework_TestCase
{
    use AmqpTestHelper;

    /**
     * @var AmqpMessageSender
     */
    private $amqpMessageSender;

    /**
     * @var EndpointSerializesDataBeforeSending
     */
    private $endpoint;

    /**
     * @var DeclaredExchange
     */
    private $exchange;

    /**
     * @var DeclaredQueue
     */
    private $queue;

    protected function setUp()
    {
        $this->exchange = ExchangeBuilder::create($this->getAmqpChannel(), 'events')->declareExchange();
        $this->queue = $this->exchange
            ->buildQueue('events_of_specific_type')
            ->withBinding('events_of_specific_type')
            ->declareQueue();
        $this->queue->purge();

        $this->amqpMessageSender = new AmqpMessageSender(
            $this->exchange,
            'events_of_specific_type',
            new GenericMessageFactory()
        );

        $this->endpoint = new EndpointSerializesDataBeforeSending(
            new PreConfiguredMessageFactory(ContentType::json()),
            new NormalizeAndEncodeObjectSerializer(
                new SimpleNormalizer(),
                new JsonEncoder()
            ),
            $this->amqpMessageSender
        );
    }

    /**
     * @test
     */
    public function it_produces_a_message_based_on_an_object()
    {
        $this->getAmqpChannel();

        $value = 'Hello world';
        $this->endpoint->send(new NormalizableObject($value));

        $actualMessage = $this->waitForOneMessage($this->queue);

        $this->assertSame('{"field":"Hello world"}', $actualMessage->body);
        $this->assertSame('application/json', $actualMessage->get('content_type'));
        $this->assertTrue(Uuid::isValid($actualMessage->get('message_id')));
    }
}
