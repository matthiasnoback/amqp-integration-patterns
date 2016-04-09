<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\Amqp\ChannelFactory;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\MessageChannel;
use AMQPIntegrationPatterns\Message\PreConfiguredMessageFactory;
use AMQPIntegrationPatterns\Serialization\EndpointSerializesDataBeforeSending;
use AMQPIntegrationPatterns\Serialization\JsonEncoder;
use AMQPIntegrationPatterns\Serialization\NormalizeAndEncodeObjectSerializer;
use AMQPIntegrationPatterns\Serialization\SimpleNormalizer;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\TestDoubles\NormalizableObject;
use Ramsey\Uuid\Uuid;

class EndpointSerializesDataBeforeSendingTest extends \PHPUnit_Framework_TestCase
{
    use AmqpTestHelper;

    /**
     * @var MessageChannel
     */
    private $amqpMessageChannel;

    /**
     * @var EndpointSerializesDataBeforeSending
     */
    private $endpoint;

    protected function setUp()
    {
        $this->amqpMessageChannel = (new ChannelFactory($this->getAmqpChannel()))->createEventMessageChannel(md5(uniqid()));

        $this->endpoint = new EndpointSerializesDataBeforeSending(
            new PreConfiguredMessageFactory(ContentType::json()),
            new NormalizeAndEncodeObjectSerializer(
                new SimpleNormalizer(),
                new JsonEncoder()
            ),
            $this->amqpMessageChannel
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

        $actualMessage = $this->waitForOneMessage($this->amqpMessageChannel);

        $this->assertSame('{"field":"Hello world"}', $actualMessage->body);
        $this->assertSame('application/json', $actualMessage->get('content_type'));
        $this->assertTrue(Uuid::isValid($actualMessage->get('message_id')));
    }
}
