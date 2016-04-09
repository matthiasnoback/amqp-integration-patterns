<?php

namespace AMQPIntegrationPatterns\Serialization;

use AMQPIntegrationPatterns\Message\Message;

interface Deserializer
{
    /**
     * @param Message $message
     * @return mixed
     */
    public function deserialize(Message $message);
}
