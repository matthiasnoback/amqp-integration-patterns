<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredExchange;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use AMQPIntegrationPatterns\Amqp\Fabric\QueueConsumer;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\AmqpTestHelper;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric\TestDoubles\ConsumerSpy;
use PhpAmqpLib\Message\AMQPMessage;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    use AmqpTestHelper;

    /**
     * @var DeclaredExchange
     */
    private $declaredExchange;

    /**
     * @var DeclaredQueue
     */
    private $declaredQueue;

    protected function setUp()
    {
        $this->declaredExchange = ExchangeBuilder::create($this->getAmqpChannel(), $this->randomExchangeName())
            ->declareExchange();

        $this->declaredQueue = $this->declaredExchange->buildQueue('events_of_specific_type')
            ->withBinding('events_of_specific_type')
            ->declareQueue();
    }

    /**
     * @test
     */
    public function it_can_publish_messages_to_a_queue_and_read_a_message_from_it()
    {
        $this->declaredQueue->purge();

        // publish a message
        $bodyText = '{"message":"Hello"}';

        $amqpMessage = new AMQPMessage($bodyText);

        $this->declaredExchange->publish($amqpMessage, 'events_of_specific_type');

        /** @var QueueConsumer $queueConsumer */
        $queueConsumer = null;

        $consumerSpy = new ConsumerSpy(); // TODO wait for one message

        $queueConsumer = $this->declaredQueue->consume($consumerSpy);

        $queueConsumer->wait();

        $this->assertSame($bodyText, $consumerSpy->amqpMessage->body);
    }

    private function randomExchangeName()
    {
        return md5(uniqid());
    }
}
