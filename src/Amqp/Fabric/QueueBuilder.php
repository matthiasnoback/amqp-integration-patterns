<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use AMQPIntegrationPatterns\ProcessIdentifier;
use PhpAmqpLib\Channel\AMQPChannel;

final class QueueBuilder
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var ExchangeName
     */
    private $exchangeName;

    /**
     * @var ProcessIdentifier
     */
    private $processIdentifier;

    /**
     * @var QueueName
     */
    private $queueName;

    private $bindings = [];

    private function __construct()
    {
    }

    public static function create(
        AMQPChannel $channel,
        ExchangeName $exchangeName,
        ProcessIdentifier $processIdentifier,
        $name
    ) {
        $queueBuilder = new self();
        $queueBuilder->channel = $channel;
        $queueBuilder->exchangeName = $exchangeName;
        $queueBuilder->processIdentifier = $processIdentifier;
        $queueBuilder->queueName = new QueueName($name);

        return $queueBuilder;
    }

    /**
     * @param string $binding
     * @return QueueBuilder
     */
    public function withBinding($binding)
    {
        $this->bindings[] = new QueueBinding($this->exchangeName, $binding);

        return $this;
    }

    public function declareQueue()
    {
        return new DeclaredQueue($this->channel, $this->queueName, $this->bindings, $this->processIdentifier);
    }
}
