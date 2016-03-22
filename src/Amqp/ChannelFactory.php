<?php

namespace AMQPIntegrationPatterns\Amqp;

use PhpAmqpLib\Channel\AMQPChannel;

class ChannelFactory
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
        $exchangeName = 'events';

        $this->channel->exchange_declare(
            $exchangeName,
            'topic',
            false, // passive
            true, // durable
            false // autodelete
        );

        list($queueName) = $this->channel->queue_declare(
            '',
            false, // passive
            true, // durable
            false, // exclusive
            false // autodelete
        );

        $routingKey = $eventName;

        $this->channel->queue_bind($queueName, $exchangeName, $eventName);

        return new AmqpMessageChannel($this->channel, $queueName, $exchangeName, $routingKey, new MessageFactory());
    }
}
