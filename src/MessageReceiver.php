<?php

namespace AMQPIntegrationPatterns;

interface MessageReceiver
{
    /**
     * @param callable $callback
     * @throws MessageIsInvalid
     * @return void
     */
    public function waitForMessages(callable $callback);
}
