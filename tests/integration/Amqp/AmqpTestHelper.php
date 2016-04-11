<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\DeclaredQueue;
use AMQPIntegrationPatterns\Amqp\Fabric\QueueConsumer;
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
        $callback = function (AMQPMessage $amqpMessage, QueueConsumer $consumer) use (&$actualMessage) {
            $actualMessage = $amqpMessage;
            $consumer->stopWaiting();
        };

        $queue->consume($callback)->waitForMessage();

        Assertion::isInstanceOf($actualMessage, AMQPMessage::class);

        return $actualMessage;
    }
}
