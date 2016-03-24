<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class DeclaredExchange
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var ExchangeName
     */
    private $exchangeName;

    public function __construct(AMQPChannel $channel, ExchangeName $name)
    {
        $this->channel = $channel;
        $this->exchangeName = $name;
    }

    public function buildQueue($queueName)
    {
        return QueueBuilder::create($this->channel, $this->exchangeName, $queueName);
    }

    public function publish(AMQPMessage $amqpMessage, $routingKey)
    {
        $this->channel->basic_publish($amqpMessage, (string) $this->exchangeName, $routingKey);
    }
}
