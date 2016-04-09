<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles;

use AMQPIntegrationPatterns\Serialization\Normalization\CanBeNormalized;

class ImproperlyNormalizingClass implements CanBeNormalized
{
    public function normalize()
    {
        // not a valid return value
        return null;
    }
}
