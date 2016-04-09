<?php

namespace AMQPIntegrationPatterns\Serialization\Normalization;

class CouldNotDenormalizeObject extends \LogicException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
