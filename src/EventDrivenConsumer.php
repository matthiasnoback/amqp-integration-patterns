<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\BlockingIo\Blocking;

/**
 * An event-driven consumer waits for a new message to arrive and consumes it accordingly.
 */
interface EventDrivenConsumer extends Blocking
{
}
