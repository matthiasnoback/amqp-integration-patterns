<?php

namespace AMQPIntegrationPatterns\Serialization;

interface Serializer
{
    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data);
}
