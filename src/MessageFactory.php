<?php

namespace AMQPIntegrationPatterns;

interface MessageFactory
{
    /**
     * @param string $body
     * @return Message
     */
    public function createMessageWithBody($body);
}
