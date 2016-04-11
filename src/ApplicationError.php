<?php

namespace AMQPIntegrationPatterns;

class ApplicationError extends \Exception
{
    public static function fromException(\Exception $previous)
    {
        return new self('An application error occurred while processing a message', 0, $previous);
    }
}
