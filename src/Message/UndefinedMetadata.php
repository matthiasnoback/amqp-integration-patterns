<?php

namespace AMQPIntegrationPatterns\Message;

class UndefinedMetadata extends \LogicException
{
    public static function forKey($key)
    {
        return new self(sprintf(
            'No metadata has been defined for key "%s"',
            $key
        ));
    }
}
