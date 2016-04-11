<?php

namespace AMQPIntegrationPatterns\Amqp;

use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeBuilder;
use AMQPIntegrationPatterns\ProcessIdentifier;
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

        // TODO use an "inflector" of some kind to generate a proper queue name
        $queueName = str_replace('.', '_', $eventName);
        $routingKey = $eventName;

        $declaredQueue = $declaredExchange->buildQueue($queueName)
            ->withBinding($routingKey)
            ->declareQueue();

        return new AmqpMessageSender($declaredExchange, $declaredQueue, $routingKey, new MessageFactory());
    }
}
