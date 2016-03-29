<?php

namespace AMQPIntegrationPatterns\Serialization;

class CouldNotEncodeData extends \LogicException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
