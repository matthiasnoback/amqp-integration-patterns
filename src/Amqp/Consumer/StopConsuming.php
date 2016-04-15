<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

/**
 * Throw this exception from inside a consumer to make the AMQP message consumer stop consuming new messages.
 */
class StopConsuming extends \RuntimeException
{
}
