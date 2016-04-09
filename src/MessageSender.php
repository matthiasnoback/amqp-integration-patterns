<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Message;

interface MessageSender
{
    /**
     * @param Message $message
     * @return void
     */
    public function send(Message $message);
}
