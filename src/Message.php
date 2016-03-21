<?php

namespace AMQPIntegrationPatterns;

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
