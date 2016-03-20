<?php

namespace AMQPIntegrationPatterns;

use Assert\Assertion;

class Body
{
    private $text;

    public function __construct($text)
    {
        Assertion::string($text);

        $this->text = $text;
    }

    public static function emptyBody()
    {
        return new self('');
    }

    public function __toString()
    {
        return $this->text;
    }
}
