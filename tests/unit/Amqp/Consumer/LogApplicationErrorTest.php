<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Consumer;

use AMQPIntegrationPatterns\Amqp\Consumer\Consumer;
use AMQPIntegrationPatterns\Amqp\Consumer\LogApplicationError;
use AMQPIntegrationPatterns\Amqp\ConsumptionFlag;
use AMQPIntegrationPatterns\ApplicationError;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class LogApplicationErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_logs_and_rethrows_a_catched_application_error()
    {
        $amqpMessage = new AMQPMessage();
        $innerConsumer = $this->prophesize(Consumer::class);
        $exception = new ApplicationError('Some exception');
        $innerConsumer->consume($amqpMessage)->willThrow($exception);

        $logger = $this->prophesize(LoggerInterface::class);
        $logger->critical(
            'An application error occurred while processing a message',
            [
                'message' => $exception->getMessage(),
                'exception' => $exception,
                'amqp_message' => $amqpMessage
            ]
        )->shouldBeCalled();

        $consumer = new LogApplicationError($innerConsumer->reveal(), $logger->reveal());
        try {
            $consumer->consume($amqpMessage);
            $this->fail();
        } catch (ApplicationError $actualException) {
            $this->assertSame($exception, $actualException);
        }
    }

    /**
     * @test
     */
    public function it_returns_the_result_of_the_inner_consumer()
    {
        $amqpMessage = new AMQPMessage();

        $innerConsumer = $this->prophesize(Consumer::class);
        $consumptionFlag = ConsumptionFlag::reject();
        $innerConsumer->consume($amqpMessage)->willReturn($consumptionFlag);

        $logger = $this->prophesize(LoggerInterface::class);

        $consumer = new LogApplicationError(
            $innerConsumer->reveal(),
            $logger->reveal()
        );

        $actualConsumptionFlag = $consumer->consume($amqpMessage);
        $this->assertEquals($consumptionFlag, $actualConsumptionFlag);
    }
}
