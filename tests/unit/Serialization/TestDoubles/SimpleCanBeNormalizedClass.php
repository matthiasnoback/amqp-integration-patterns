<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles;

use AMQPIntegrationPatterns\Serialization\CanBeDenormalized;
use AMQPIntegrationPatterns\Serialization\CanBeNormalized;

class SimpleCanBeNormalizedClass implements CanBeNormalized, CanBeDenormalized
{
    private $field;

    public function __construct($value)
    {
        $this->field = $value;
    }

    public function normalize()
    {
        return ['field' => $this->field];
    }

    public static function denormalize(array $data)
    {
        return new self($data['field']);
    }
}
