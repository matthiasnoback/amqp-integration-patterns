<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles;

use AMQPIntegrationPatterns\Serialization\Deserializable;

class ImproperlyDeserializingClass implements Deserializable
{
    public static function deserialize(array $data)
    {
        // not an object of this class
        return null;
    }
}
