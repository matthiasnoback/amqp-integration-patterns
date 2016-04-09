<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Message;

/**
 * This type of endpoint can be used for receiving messages. It should be implemented in user-land.
 */
interface EndpointForReceiving extends Endpoint
{
    /**
     * @param mixed $data
     * @param Message $message
     * @return void
     */
    public function accept($data, Message $message);
}
