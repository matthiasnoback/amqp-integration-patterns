<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\Amqp\Consumer\ConsumeMaximumAmount;
use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric\TestDoubles\ConsumerSpy;
use Assert\Assertion;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

trait AmqpTestHelper
{
    private $connection;
    private $channel;

    protected function getAmqpChannel()
    {
        if ($this->channel === null) {
            $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest', '/');
            $this->channel = $connection->channel();
        }

        return $this->channel;
    }

    /**
     * @param DeclaredQueue $queue
     * @return AMQPMessage
     */
    protected function waitForOneMessage(DeclaredQueue $queue)
    {
        $actualMessage = null;

        $consumerSpy = new ConsumerSpy();
        $queue->consume(new ConsumeMaximumAmount($consumerSpy, 1))->wait();

        $actualMessage = $consumerSpy->amqpMessage;
        Assertion::isInstanceOf($actualMessage, AMQPMessage::class);

        return $actualMessage;
    }
}
