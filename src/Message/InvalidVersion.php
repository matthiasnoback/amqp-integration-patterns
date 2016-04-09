<?php

namespace AMQPIntegrationPatterns\Message;

final class InvalidVersion extends \LogicException
{
    public static function forValue($value, \Exception $previous = null)
    {
        return new self(
            sprintf(
                'Value "%s" is not a correctly formatted version number',
                $value
            ),
            0,
            $previous
        );
    }
}
