<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use Assert\Assertion;

final class QueueBinding
{
    /**
     * @var DeclaredExchange
     */
    private $exchangeName;

    /**
     * @var string
     */
    private $routingKey;

    public function __construct(ExchangeName $exchangeName, $routingKey)
    {
        $this->exchangeName = $exchangeName;

        // TODO verify this assumption, wrap in VO
        Assertion::regex($routingKey, '/^([\w#\*]+)(\.[\w#\*]+)*/', 'Invalid characters in queue binding');
        $this->routingKey = $routingKey;
    }

    /**
     * @return DeclaredExchange
     */
    public function exchangeName()
    {
        return $this->exchangeName;
    }

    /**
     * @return string
     */
    public function routingKey()
    {
        return $this->routingKey;
    }
}
