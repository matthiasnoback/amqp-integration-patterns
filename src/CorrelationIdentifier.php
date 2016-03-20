<?php

namespace AMQPIntegrationPatterns;

use Assert\Assertion;

final class CorrelationIdentifier
{
    /**
     * @var string
     */
    private $correlationIdentifier;

    public function __construct($correlationIdentifier)
    {
        Assertion::string($correlationIdentifier);

        $this->correlationIdentifier = $correlationIdentifier;
    }


}
