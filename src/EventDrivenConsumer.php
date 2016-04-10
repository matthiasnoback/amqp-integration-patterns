<?php

namespace AMQPIntegrationPatterns;

/**
 * An event-driven consumer waits for a new message to arrive and consumes it accordingly.
 */
interface EventDrivenConsumer
{
    /**
     * TODO solve this with decoration (implement an actual consumer, which just stops the consumer)
     */
    public function waitForOneMessage();

    public function waitForMessages();
}
