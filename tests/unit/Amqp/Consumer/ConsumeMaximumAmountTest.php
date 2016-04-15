<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer\ConsumeMaximumAmount;
use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\StopConsuming;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeMaximumAmountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_consumes_n_messages_then_throws_an_exception()
    {
        $amqpMessage = new AMQPMessage();

        $innerConsumer = $this->prophesize(Consumer::class);
        $innerConsumer->consume($amqpMessage)->shouldBeCalledTimes(3);

        $consumeOneMessage = new ConsumeMaximumAmount($innerConsumer->reveal(), 3);

        $consumeOneMessage->consume($amqpMessage);
        $consumeOneMessage->consume($amqpMessage);

        // the third message will be consumed, but an exception will be thrown as well
        $this->setExpectedException(StopConsuming::class);
        $consumeOneMessage->consume($amqpMessage);
    }
}
