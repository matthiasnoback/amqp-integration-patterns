<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use AMQPIntegrationPatterns\ProcessIdentifier;
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
    /**
     * @var ProcessIdentifier
     */
    private $processIdentifier;

    public static function create(AMQPChannel $channel, $name)
    {
        $exchangeBuilder = new self();
        $exchangeBuilder->channel = $channel;
        $exchangeBuilder->processIdentifier = ProcessIdentifier::fromSystemGlobals();
        $exchangeBuilder->name = $name;

        return $exchangeBuilder;
    }
    
    public function declareExchange()
    {
        return new DeclaredExchange($this->channel, new ExchangeName($this->name), $this->processIdentifier);
    }
}
