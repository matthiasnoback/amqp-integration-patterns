<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\TestDoubles;

use AMQPIntegrationPatterns\Serialization\Normalization\CanBeNormalized;

class NormalizableObject implements CanBeNormalized
{
    private $field;

    public function __construct($value)
    {
        $this->field = $value;
    }

    public function normalize()
    {
        return [
            'field' => $this->field
        ];
    }
}
