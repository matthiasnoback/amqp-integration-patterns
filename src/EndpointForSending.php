<?php

namespace AMQPIntegrationPatterns;

interface EndpointForSending extends Endpoint
{
    /**
     * @param mixed $data
     * @return void
     */
    public function send($data);
}
