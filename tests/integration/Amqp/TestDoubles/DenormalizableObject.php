<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\TestDoubles;

use AMQPIntegrationPatterns\Serialization\Normalization\CanBeDenormalized;

class DenormalizableObject implements CanBeDenormalized
{
    private $field;

    public function __construct($value)
    {
        $this->field = $value;
    }

    public static function denormalize(array $data)
    {
        return new self($data['field']);
    }
}
