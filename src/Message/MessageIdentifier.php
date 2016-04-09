<?php

namespace AMQPIntegrationPatterns\Message;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

final class MessageIdentifier
{
    private $messageIdentifier;

    public function __construct($messageIdentifier)
    {
        Assertion::string($messageIdentifier);

        $this->messageIdentifier = $messageIdentifier;
    }

    public static function random()
    {
        return new self((string) Uuid::uuid4());
    }

    public function __toString()
    {
        return $this->messageIdentifier;
    }
}
