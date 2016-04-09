<?php

namespace AMQPIntegrationPatterns\Serialization\Encoding;

class CouldNotDecodeData extends \LogicException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
