<?php

namespace AMQPIntegrationPatterns\Message;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\MessageIdentifier;

/**
 * TODO add message type and metadata
 */
interface Message
{
    /**
     * @return MessageIdentifier
     */
    public function messageIdentifier();

    /**
     * @return Body
     */
    public function body();
}
