<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles;

use AMQPIntegrationPatterns\Serialization\Normalization\CanBeDenormalized;

class ImproperlyDenormalizingClass implements CanBeDenormalized
{
    public static function denormalize(array $data)
    {
        // not an object of this class
        return null;
    }
}
