<?php


namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;


use AMQPIntegrationPatterns\Amqp\AmqpMessageChannel;
use AMQPIntegrationPatterns\Amqp\ChannelFactory;
use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\ContentType;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\MessageIdentifier;

class AmqpMessageChannelTest extends \PHPUnit_Framework_TestCase
{
    use AmqpTestHelper;

    /**
     * @var AmqpMessageChannel
     */
    private $amqpMessageChannel;

    protected function setUp()
    {
        $channelFactory = new ChannelFactory($this->getAmqpChannel());
        $this->amqpMessageChannel = $channelFactory->createEventMessageChannel('event.name');
    }

    /**
     * @test
     */
    public function it_can_publish_messages_to_a_queue_and_read_a_message_from_it()
    {
        $this->amqpMessageChannel->purge();

        // publish a message
        $bodyText = '{"message":"Hello"}';
        $contentType = 'application/json';
        $messageIdentifier = MessageIdentifier::random();
        $eventMessage = EventMessage::create(
            $messageIdentifier,
            new Body(ContentType::fromString($contentType), $bodyText)
        );

        $this->amqpMessageChannel->send($eventMessage);

        // read a message
        $actualMessage = $this->waitForOneMessage($this->amqpMessageChannel);
        $this->assertSame($bodyText, $actualMessage->body);
        $this->assertSame($contentType, $actualMessage->get('content_type'));
        $this->assertSame((string)$messageIdentifier, $actualMessage->get('message_id'));
    }
}
