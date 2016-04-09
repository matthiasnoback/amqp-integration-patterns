<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp;

use AMQPIntegrationPatterns\Amqp\ConsumptionFlag;
use AMQPIntegrationPatterns\Amqp\PublishInvalidMessageToInvalidMessageChannel;
use AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles\AlwaysSucceedingConsumer;
use AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles\ConsumerFailsBecauseMessageIsInvalid;
use AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles\AmqpMessageDummy;
use AMQPIntegrationPatterns\Tests\Unit\Amqp\TestDoubles\AlwaysSucceedingProducer;

class PublishInvalidMessageToInvalidMessageChannelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_lets_the_next_consumer_consume_the_message()
    {
        $messageDummy = new AmqpMessageDummy();

        $nextReceiverMock = new AlwaysSucceedingConsumer();

        $receiver = new PublishInvalidMessageToInvalidMessageChannel($nextReceiverMock, new AlwaysSucceedingProducer());
        $consumptionFlag = $receiver->consume($messageDummy);

        $this->assertSame($messageDummy, $nextReceiverMock->actualMessage);
        $this->assertEquals(ConsumptionFlag::acknowledge(), $consumptionFlag);
    }

    /**
     * @test
     */
    public function it_publishes_the_message_that_is_found_to_be_invalid_to_an_invalid_message_channel()
    {
        $messageDummy = new AmqpMessageDummy();

        $nextReceiverMock = new ConsumerFailsBecauseMessageIsInvalid();

        $producerMock = new AlwaysSucceedingProducer();
        $receiver = new PublishInvalidMessageToInvalidMessageChannel($nextReceiverMock, $producerMock);
        $consumptionFlag = $receiver->consume($messageDummy);
        $this->assertEquals(ConsumptionFlag::reject(), $consumptionFlag);

        $this->assertSame($messageDummy, $nextReceiverMock->actualMessage);
        $this->assertSame($messageDummy, $producerMock->actualMessage);
    }
}
