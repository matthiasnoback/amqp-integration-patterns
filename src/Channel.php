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
    public function write(Message $message);
}
