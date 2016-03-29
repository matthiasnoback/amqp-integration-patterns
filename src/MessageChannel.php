<?php


namespace AMQPIntegrationPatterns;

/**
 * TODO split into read and write message endpoints (channel is not something represented in code actually)
 */
interface MessageChannel
{
    /**
     * Write a message to this channel
     *
     * @param Message $message
     * @return void
     */
    public function send(Message $message);

    /**
     * Start waiting for new messages
     *
     * @param callable $callback Will be called for each new message received through this channel
     * @return void
     */
    public function waitForMessages(callable $callback);

    /**
     * Purge the queue associated with this channel
     * @return void
     */
    public function purge();
}
