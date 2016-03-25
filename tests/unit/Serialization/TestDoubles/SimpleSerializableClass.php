<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles;

use AMQPIntegrationPatterns\Serialization\Deserializable;
use AMQPIntegrationPatterns\Serialization\Serializable;

class SimpleSerializableClass implements Serializable, Deserializable
{
    private $field;

    public function __construct($value)
    {
        $this->field = $value;
    }

    public function serialize()
    {
        return ['field' => $this->field];
    }

    public static function deserialize(array $data)
    {
        return new self($data['field']);
    }
}
