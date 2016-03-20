<?php

namespace AMQPIntegrationPatterns;

interface Receiver
{
    /**
     * @param Message $message
     * @throws MessageIsInvalid
     * @return void
     */
    public function process(Message $message);
}
