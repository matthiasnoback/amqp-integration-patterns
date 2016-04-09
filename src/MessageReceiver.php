<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Message;

interface MessageReceiver
{
    /**
     * @param Message $message
     * @return void
     */
    public function receive(Message $message);
}
