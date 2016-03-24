<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use PhpAmqpLib\Channel\AMQPChannel;

class QueueBuilder
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
     * @var QueueName
     */
    private $queueName;

    private $bindings = [];

    private function __construct()
    {
    }

    public static function create(AMQPChannel $channel, ExchangeName $exchangeName, $name)
    {
        $queueBuilder = new self();
        $queueBuilder->channel = $channel;
        $queueBuilder->exchangeName = $exchangeName;
        $queueBuilder->queueName = new QueueName($name);

        return $queueBuilder;
    }

    public function withBinding($binding)
    {
        $this->bindings[] = new QueueBinding($this->exchangeName, $binding);

        return $this;
    }

    public function declareQueue()
    {
        return new DeclaredQueue($this->channel, $this->queueName, $this->bindings);
    }
}
