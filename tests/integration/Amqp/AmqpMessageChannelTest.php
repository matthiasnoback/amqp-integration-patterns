<?php


namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;


use AMQPIntegrationPatterns\Amqp\AmqpMessageChannel;
use AMQPIntegrationPatterns\Amqp\ChannelFactory;
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
        $callback = function(AMQPMessage $amqpMessage) use ($bodyText, $contentType, $messageIdentifier) {
            $this->assertSame($bodyText, $amqpMessage->body);
            $this->assertSame($contentType, $amqpMessage->get('content_type'));
            $this->assertSame((string) $messageIdentifier, $amqpMessage->get('message_id'));

            $this->amqpMessageChannel->stopWaiting();
        };

        $this->amqpMessageChannel->waitForMessages($callback);
    }
}
