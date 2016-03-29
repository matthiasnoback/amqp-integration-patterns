<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeBuilder
{
    /**
     * @var AMQPChannel
     */
    private $channel;
    
    /**
     * @var string
     */
    private $name;

    private function __construct(AMQPChannel $channel, $name)
    {
        $this->channel = $channel;
        $this->name = $name;
    }

    public static function create(AMQPChannel $channel, $name)
    {
        return new self($channel, $name);
    }

    public function declareExchange()
    {
        return new DeclaredExchange($this->channel, new ExchangeName($this->name));
    }
}
