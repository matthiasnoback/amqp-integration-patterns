<?php

namespace AMQPIntegrationPatterns;

/**
 * A message is invalid when the receiving application is not able to process it, e.g. when:
 * - The message body causes parsing errors, lexical errors, or validation errors
 * - Needed properties are missing or the property values make no sense
 * - The message has been put on the wrong channel
 * - The message is of an incorrect data type
 * -
 */
class MessageIsInvalid extends \LogicException
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
