<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp;

use PhpAmqpLib\Connection\AMQPStreamConnection;

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
}
