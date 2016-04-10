<?php

namespace AMQPIntegrationPatterns;

use Assert\Assertion;

final class ProcessIdentifier
{
    /**
     * @var string
     */
    private $processIdentifier;

    public static function fromSystemGlobals()
    {
        $processIdentifier = new self();
        $processIdentifier->processIdentifier = sprintf('PHPPROCESS_%s_%s', gethostname(), getmypid());

        return $processIdentifier;
    }

    public static function fromString($string)
    {
        Assertion::string($string);
        Assertion::notEmpty($string);

        $processIdentifier = new self();
        $processIdentifier->processIdentifier = $string;

        return $processIdentifier;
    }

    public function __toString()
    {
        return $this->processIdentifier;
    }
}
