<?php

namespace AMQPIntegrationPatterns;

/**
 * This type of endpoint can be used to send data to (e.g. an object representing a message).
 */
interface EndpointForSending extends Endpoint
{
    /**
     * @param mixed $data
     * @return void
     */
    public function send($data);
}
