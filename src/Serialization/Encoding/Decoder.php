<?php

namespace AMQPIntegrationPatterns\Serialization\Encoding;

use AMQPIntegrationPatterns\Message\Body;

interface Decoder
{
    /**
     * @param Body $body
     * @return array Structured data
     */
    public function decode(Body $body);
}
