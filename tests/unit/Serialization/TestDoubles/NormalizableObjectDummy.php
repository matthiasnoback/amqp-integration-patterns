<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles;

use AMQPIntegrationPatterns\Serialization\CanBeNormalized;

class NormalizableObjectDummy implements CanBeNormalized
{
    public function normalize()
    {
    }
}
