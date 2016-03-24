<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use Assert\Assertion;

class QueueName
{
    /**
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        // TODO verify this assumption:
        Assertion::regex($name, '/^[a-zA-Z_-]+$/', 'Invalid queue name');
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
