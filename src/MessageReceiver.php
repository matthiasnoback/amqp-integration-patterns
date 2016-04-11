<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Message;

interface MessageReceiver
{
    /**
     * @param Message $message
     * @throws MessageIsInvalid When the message is structurally incorrect.
     * @throws ApplicationError When some other problem occurred while the application processes the message.
     * @return void
     */
    public function receive(Message $message);
}
