<?php

namespace AMQPIntegrationPatterns\Message;

interface MessageFactory
{
    /**
     * @param string $body
     * @return Message
     */
    public function createMessageWithBody($body);
}
