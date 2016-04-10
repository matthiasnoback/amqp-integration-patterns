<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use AMQPIntegrationPatterns\Amqp\Fabric\DecoratableAmqpChannel;
use PhpAmqpLib\Channel\AMQPChannel;

class AmqpChannelDecorator implements DecoratableAmqpChannel
{
    /**
     * @var AMQPChannel
     */
    private $decoratedChannel;

    public function __construct(AMQPChannel $decoratedChannel)
    {
        $this->decoratedChannel = $decoratedChannel;
    }

    public function queue_purge($queue = '', $nowait = false, $ticket = null)
    {
        return $this->decoratedChannel->queue_purge(...func_get_args());
    }

    public function basic_publish(
        $msg,
        $exchange = '',
        $routing_key = '',
        $mandatory = false,
        $immediate = false,
        $ticket = null
    ) {
        $this->decoratedChannel->basic_publish(...func_get_args());
    }

    public function queue_declare(
        $queue = '',
        $passive = false,
        $durable = false,
        $exclusive = false,
        $auto_delete = true,
        $nowait = false,
        $arguments = null,
        $ticket = null
    ) {
        return $this->decoratedChannel->queue_declare(...func_get_args());
    }

    public function queue_bind(
        $queue,
        $exchange,
        $routing_key = '',
        $nowait = false,
        $arguments = null,
        $ticket = null
    ) {
        return $this->decoratedChannel->queue_bind(...func_get_args());
    }

    public function callbacks()
    {
        return $this->decoratedChannel->callbacks;
    }

    public function wait($allowed_methods = null, $non_blocking = false, $timeout = 0)
    {
        return $this->decoratedChannel->wait(...func_get_args());
    }
}
