<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use AMQPIntegrationPatterns\ProcessIdentifier;
use Assert\Assertion;
use PhpAmqpLib\Channel\AMQPChannel;

final class DeclaredQueue
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var QueueName
     */
    private $name;
    /**
     * @var ProcessIdentifier
     */
    private $processIdentifier;

    public function __construct(
        AMQPChannel $channel,
        QueueName $name,
        array $bindings,
        ProcessIdentifier $processIdentifier
    ) {
        $this->channel = $channel;
        $this->name = $name;
        Assertion::allIsInstanceOf($bindings, QueueBinding::class);

        $this->declareQueueAndBindings(
            $channel,
            $name,
            $bindings
        );

        $this->processIdentifier = $processIdentifier;
    }

    /**
     * @param AMQPChannel $channel
     * @param QueueName $name
     * @param QueueBinding[] $bindings
     */
    private function declareQueueAndBindings(AMQPChannel $channel, QueueName $name, array $bindings)
    {
        $channel->queue_declare(
            (string)$name,
            false, // passive
            true, // durable
            false, // exclusive
            false, // auto-delete
            false, // no-wait
            null, // arguments
            null // ticket
        );

        foreach ($bindings as $binding) {
            $this->channel->queue_bind((string)$name, (string)$binding->exchangeName(), $binding->routingKey());
        }
    }

    public function consume(callable $callback)
    {
        return new QueueConsumer($this->channel, $this->processIdentifier, $this, $callback);
    }

    public function name()
    {
        return $this->name;
    }

    public function purge()
    {
        $this->channel->queue_purge((string)$this->name);
    }
}
