<?php


namespace AMQPIntegrationPatterns;

interface Channel
{
    /**
     * Write a message to this channel
     *
     * @param Message $message
     * @return void
     */
    public function publish(Message $message);

    /**
     * Start waiting for new messages
     *
     * @param callable $callback Will be called for each new message received through this channel
     * @return void
     */
    public function waitForMessages(callable $callback);
}
