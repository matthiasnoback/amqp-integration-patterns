<?php

namespace AMQPIntegrationPatterns\Serialization;

class CouldNotNormalizeObject extends \LogicException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
