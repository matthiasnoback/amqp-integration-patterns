<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Message;

interface Translator
{
    /**
     * Translate a message, i.e. create a new message with different:
     * 
     * - data structure (e.g. condense many-to-many relationships into aggregation)
     * - different data types (e.g. convert ZIP code from numeric to string)
     * - different data representation (e.g. parse data representation and render in a different format)
     *
     * If you need to resend the message using a different transport, instead implement a ChannelAdapter
     *
     * @param Message $message
     * @return Message
     */
    public function translate(Message $message);
}
