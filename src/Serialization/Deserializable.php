<?php

namespace AMQPIntegrationPatterns\Serialization;

interface Deserializable
{
    /**
     * Construct an instance of this class based on the provided data.
     *
     * @param array $data
     * @return self
     */
    public static function deserialize(array $data);
}
