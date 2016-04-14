<?php

namespace AMQPIntegrationPatterns\Amqp\Consumer;

/**
 * Throw this exception from inside a consumer to make the AMQP message consumer stop waiting for new messages
 */
class StopWaiting extends \RuntimeException
{
}
