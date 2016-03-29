<?php

namespace AMQPIntegrationPatterns\Serialization;

interface CanBeNormalized
{
    /**
     * Get an array representing the internal data, which can be used to reconstitute the object.
     *
     * @return array
     */
    public function normalize();
}
