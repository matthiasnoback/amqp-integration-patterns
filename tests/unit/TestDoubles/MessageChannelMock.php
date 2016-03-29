<?php


namespace AMQPIntegrationPatterns\Tests\Unit\TestDoubles;


use AMQPIntegrationPatterns\MessageChannel;
use AMQPIntegrationPatterns\Message;

class MessageChannelMock implements MessageChannel
{
    public $actualMessage;

    public function send(Message $message)
    {
        $this->actualMessage = $message;
    }

    public function waitForMessages(callable $callback)
    {
    }

    public function purge()
    {
    }
}
