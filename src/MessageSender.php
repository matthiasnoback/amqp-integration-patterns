<?php

namespace AMQPIntegrationPatterns;

interface MessageSender
{
    /**
     * @param Message $message
     * @return void
     */
    public function send(Message $message);
}
