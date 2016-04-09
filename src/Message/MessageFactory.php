<?php

namespace AMQPIntegrationPatterns\Message;

use AMQPIntegrationPatterns\Message\Message;

interface MessageFactory
{
    /**
     * @param string $body
     * @return Message
     */
    public function createMessageWithBody($body);
}
