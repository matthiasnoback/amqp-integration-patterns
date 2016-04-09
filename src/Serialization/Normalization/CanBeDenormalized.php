<?php

namespace AMQPIntegrationPatterns\Serialization\Normalization;

interface CanBeDenormalized
{
    /**
     * Construct an instance of this class based on the provided data.
     *
     * @param array $data
     * @return self
     */
    public static function denormalize(array $data);
}
