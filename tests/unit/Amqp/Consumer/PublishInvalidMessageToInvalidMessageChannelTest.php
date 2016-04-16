<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\PublishInvalidMessageToInvalidMessageChannel;
use AMQPIntegrationPatterns\Amqp\Producer;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use AMQPIntegrationPatterns\MessageIsInvalid;
use PhpAmqpLib\Message\AMQPMessage;

class PublishInvalidMessageToInvalidMessageChannelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_lets_the_next_consumer_consume_the_message()
    {
        $messageDummy = new AMQPMessage();

        $eventDrivenConsumerDummy = $this->prophesize(EventDrivenConsumer::class)->reveal();

        $nextReceiverMock = $this->prophesize(Consumer::class);
        $nextReceiverMock->consume($messageDummy, $eventDrivenConsumerDummy)->shouldBeCalled();

        $producerDummy = $this->prophesize(Producer::class);

        $receiver = new PublishInvalidMessageToInvalidMessageChannel(
            $nextReceiverMock->reveal(),
            $producerDummy->reveal()
        );
        $receiver->consume($messageDummy, $eventDrivenConsumerDummy);
    }

    /**
     * @test
     */
    public function it_publishes_the_invalid_message_and_rethrows_the_exception()
    {
        $messageDummy = new AMQPMessage();

        $eventDrivenConsumerDummy = $this->prophesize(EventDrivenConsumer::class)->reveal();

        $nextReceiverMock = $this->prophesize(Consumer::class);
        $messageIsInvalid = new MessageIsInvalid('This message is invalid');
        $nextReceiverMock->consume($messageDummy, $eventDrivenConsumerDummy)->willThrow($messageIsInvalid);

        $producerMock = $this->prophesize(Producer::class);
        $producerMock->publish($messageDummy)->shouldBeCalled();

        $receiver = new PublishInvalidMessageToInvalidMessageChannel(
            $nextReceiverMock->reveal(),
            $producerMock->reveal()
        );

        try {
            $receiver->consume($messageDummy, $eventDrivenConsumerDummy);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertSame($messageIsInvalid, $exception);
        }
    }

    /**
     * @test
     */
    public function it_rethrows_other_types_of_exceptions()
    {
        // TODO implement
    }
}
