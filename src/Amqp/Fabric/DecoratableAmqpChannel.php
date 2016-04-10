<?php

namespace AMQPIntegrationPatterns\Amqp\Fabric;

use PhpAmqpLib\Message\AMQPMessage;

interface DecoratableAmqpChannel
{
    /**
     * Purges a queue
     *
     * @param string $queue
     * @param bool $nowait
     * @param int $ticket
     * @return mixed|null
     */
    public function queue_purge($queue = '', $nowait = false, $ticket = null);

    /**
     * Publishes a message
     *
     * @param AMQPMessage $msg
     * @param string $exchange
     * @param string $routing_key
     * @param bool $mandatory
     * @param bool $immediate
     * @param int $ticket
     */
    public function basic_publish(
        $msg,
        $exchange = '',
        $routing_key = '',
        $mandatory = false,
        $immediate = false,
        $ticket = null
    );

    /**
     * Declares queue, creates if needed
     *
     * @param string $queue
     * @param bool $passive
     * @param bool $durable
     * @param bool $exclusive
     * @param bool $auto_delete
     * @param bool $nowait
     * @param array $arguments
     * @param int $ticket
     * @return mixed|null
     */
    public function queue_declare(
        $queue = '',
        $passive = false,
        $durable = false,
        $exclusive = false,
        $auto_delete = true,
        $nowait = false,
        $arguments = null,
        $ticket = null
    );

    /**
     * Binds queue to an exchange
     *
     * @param string $queue
     * @param string $exchange
     * @param string $routing_key
     * @param bool $nowait
     * @param array $arguments
     * @param int $ticket
     * @return mixed|null
     */
    public function queue_bind(
        $queue,
        $exchange,
        $routing_key = '',
        $nowait = false,
        $arguments = null,
        $ticket = null
    );

    /**
     * @return callable[]
     */
    public function callbacks();

    /**
     * Wait for some expected AMQP methods and dispatch to them.
     * Unexpected methods are queued up for later calls to this PHP
     * method.
     *
     * @param array $allowed_methods
     * @param bool $non_blocking
     * @param int $timeout
     * @throws \PhpAmqpLib\Exception\AMQPOutOfBoundsException
     * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
     * @return mixed
     */
    public function wait($allowed_methods = null, $non_blocking = false, $timeout = 0);
}
