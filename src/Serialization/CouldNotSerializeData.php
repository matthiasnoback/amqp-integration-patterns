<?php

namespace AMQPIntegrationPatterns\Serialization;

class CouldNotSerializeData extends \LogicException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
