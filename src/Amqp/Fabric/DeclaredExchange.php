<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use AMQPIntegrationPatterns\ProcessIdentifier;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

final class DeclaredExchange
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

    public function __construct(AMQPChannel $channel, ExchangeName $name, ProcessIdentifier $processIdentifier)
    {
        $this->channel = $channel;
        $this->exchangeName = $name;
        $this->processIdentifier = $processIdentifier;

        $this->channel->exchange_declare(
            (string) $this->exchangeName,
            'topic',
            false, // passive
            true, // durable
            false, // auto-delete
            false, // internal
            false, // no wait
            null, // arguments
            null // ticket
        );
    }

    public function buildQueue($queueName)
    {
        return QueueBuilder::create($this->channel, $this->exchangeName, $this->processIdentifier, $queueName);
    }

    public function publish(AMQPMessage $amqpMessage, $routingKey)
    {
        $this->channel->basic_publish($amqpMessage, (string) $this->exchangeName, $routingKey);
    }
}
