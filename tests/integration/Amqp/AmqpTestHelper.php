<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\QueueConsumer;
use AMQPIntegrationPatterns\MessageChannel;
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
     * @param MessageChannel $messageChannel
     * @return AMQPMessage
     */
    protected function waitForOneMessage(MessageChannel $messageChannel)
    {
        $actualMessage = null;
        $callback = function (AMQPMessage $amqpMessage, QueueConsumer $consumer) use (&$actualMessage) {
            $actualMessage = $amqpMessage;
            $consumer->stopWaiting();
        };

        $messageChannel->waitForMessages($callback);

        Assertion::isInstanceOf($actualMessage, AMQPMessage::class);

        return $actualMessage;
    }
}
