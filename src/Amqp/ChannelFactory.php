<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use PhpAmqpLib\Channel\AMQPChannel;

final class ChannelFactory
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function createEventMessageChannel($eventName)
    {
        $declaredExchange = ExchangeBuilder::create($this->channel, 'events')
            ->declareExchange();

        $queueName = str_replace('.', '_', $eventName);
        $routingKey = $eventName;

        $declaredQueue = $declaredExchange->buildQueue($queueName)
            ->withBinding($routingKey)
            ->declareQueue();

        return new AmqpMessageChannel($declaredExchange, $declaredQueue, $routingKey, new MessageFactory());
    }
}
