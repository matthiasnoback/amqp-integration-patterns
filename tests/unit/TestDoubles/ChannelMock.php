<?php


namespace AMQPIntegrationPatterns\Tests\Unit\TestDoubles;


use AMQPIntegrationPatterns\Channel;
use AMQPIntegrationPatterns\Message;

class ChannelMock implements Channel
{
    public $actualMessage;

    public function write(Message $message)
    {
        $this->actualMessage = $message;
    }
}
