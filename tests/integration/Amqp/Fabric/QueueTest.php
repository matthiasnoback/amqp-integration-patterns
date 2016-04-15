<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric;

use AMQPIntegrationPatterns\Amqp\Consumer\ConsumeMaximumAmount;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredExchange;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\AmqpTestHelper;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric\TestDoubles\SmartConsumerSpy;
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
        $this->declaredExchange = ExchangeBuilder::create($this->getAmqpChannel(), md5(uniqid()))
            ->declareExchange();

        $this->declaredQueue = $this->declaredExchange->buildQueue('events_of_specific_type')
            ->withBinding('events_of_specific_type')
            ->declareQueue();

        $this->declaredQueue->purge();
    }

    /**
     * @test
     */
    public function it_can_publish_messages_to_a_queue_and_read_a_message_from_it()
    {
        $amqpMessage0 = new AMQPMessage(md5(uniqid()));
        $this->declaredExchange->publish($amqpMessage0, 'events_of_specific_type');

        $amqpMessage1 = new AMQPMessage(md5(uniqid()));
        $this->declaredExchange->publish($amqpMessage1, 'events_of_specific_type');

        $consumerSpy = new SmartConsumerSpy();
        $queueConsumer = $this->declaredQueue->consume(new ConsumeMaximumAmount($consumerSpy, 2));

        $queueConsumer->wait();

        $this->assertSame($amqpMessage0->body, $consumerSpy->amqpMessages[0]->body);
        $this->assertSame($amqpMessage1->body, $consumerSpy->amqpMessages[1]->body);
    }

    /**
     * @test
     */
    public function it_rejects_a_message()
    {
        $this->declaredExchange->publish(
            new AMQPMessage('Consumer should fail to consume this message and reject it.'), 
            'events_of_specific_type'
        );

        $randomBodyText = md5(uniqid());
        $this->declaredExchange->publish(
            new AMQPMessage($randomBodyText),
            'events_of_specific_type'
        );

        $consumerSpy = new SmartConsumerSpy();
        $queueConsumer = $this->declaredQueue->consume(new ConsumeMaximumAmount($consumerSpy, 2));

        $queueConsumer->wait();

        $this->assertEquals($randomBodyText, reset($consumerSpy->amqpMessages)->body);
    }
}
