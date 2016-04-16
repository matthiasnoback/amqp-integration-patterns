<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer\ConsumeMaximumAmount;
use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\EventDrivenConsumer;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeMaximumAmountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_consumes_n_messages_then_throws_an_exception()
    {
        $amqpMessage = new AMQPMessage();

        $eventDrivenConsumer = $this->prophesize(EventDrivenConsumer::class);
        $eventDrivenConsumer->stopWaiting()->shouldBeCalled();
        $eventDrivenConsumer = $eventDrivenConsumer->reveal();

        $innerConsumer = $this->prophesize(Consumer::class);
        $innerConsumer->consume($amqpMessage, $eventDrivenConsumer)->shouldBeCalledTimes(3);

        $consumeOneMessage = new ConsumeMaximumAmount($innerConsumer->reveal(), 3);

        $consumeOneMessage->consume($amqpMessage, $eventDrivenConsumer);
        $consumeOneMessage->consume($amqpMessage, $eventDrivenConsumer);
        $consumeOneMessage->consume($amqpMessage, $eventDrivenConsumer);

        $this->setExpectedException(\LogicException::class);
        $consumeOneMessage->consume($amqpMessage, $eventDrivenConsumer);
    }
}
