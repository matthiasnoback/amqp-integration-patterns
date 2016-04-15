<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer\ConsumeOneMessage;
use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\StopConsuming;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeOneMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_consumes_a_message_then_throws_an_exception()
    {
        $amqpMessage = new AMQPMessage();

        $innerConsumer = $this->prophesize(Consumer::class);
        $innerConsumer->consume($amqpMessage)->shouldBeCalled();

        $consumeOneMessage = new ConsumeOneMessage($innerConsumer->reveal());

        $this->setExpectedException(StopConsuming::class);
        $consumeOneMessage->consume($amqpMessage);
    }
}
