<?php

namespace AMQPIntegrationPatterns\Serialization;

interface Serializable
{
    /**
     * Get an array representing the internal data, which can be used to reconstitute the object.
     *
     * @return array
     */
    public function serialize();
}
