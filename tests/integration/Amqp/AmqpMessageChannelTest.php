<?php


namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;


use AMQPIntegrationPatterns\Amqp\AmqpMessageChannel;
use AMQPIntegrationPatterns\Amqp\ChannelFactory;
use AMQPIntegrationPatterns\Amqp\Fabric\QueueConsumer;
use AMQPIntegrationPatterns\Body;
use AMQPIntegrationPatterns\ContentType;
use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\MessageIdentifier;
use PhpAmqpLib\Message\AMQPMessage;

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
            new Body(new ContentType($contentType), $bodyText)
        );

        $this->amqpMessageChannel->publish($eventMessage);


        // read a message
        $actualMessage = null;
        $callback = function (AMQPMessage $amqpMessage, QueueConsumer $consumer) use (
            $bodyText,
            $contentType,
            $messageIdentifier,
            &$actualMessage
        ) {
            $actualMessage = $amqpMessage;
            $consumer->stopWaiting();
        };

        $this->amqpMessageChannel->waitForMessages($callback);

        $this->assertTrue($actualMessage instanceof AMQPMessage);
        /** @var $actualMessage AMQPMessage */
        $this->assertSame($bodyText, $actualMessage->body);
        $this->assertSame($contentType, $actualMessage->get('content_type'));
        $this->assertSame((string)$messageIdentifier, $actualMessage->get('message_id'));
    }
}
