<?php

namespace AMQPIntegrationPatterns;

/**
 * An event-driven consumer waits for a new message to arrive and consumes it accordingly.
 */
interface EventDrivenConsumer
{
    public function waitForMessage();

    public function stopWaiting();
}
