<?php

namespace AMQPIntegrationPatterns\Tests\Unit\TestDoubles;

use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\MessageSender;

class MessageSenderMock implements MessageSender
{
    public $actualMessage;

    public function send(Message $message)
    {
        $this->actualMessage = $message;
    }
}
