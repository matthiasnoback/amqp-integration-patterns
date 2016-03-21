<?php

namespace AMQPIntegrationPatterns;

use Assert\Assertion;

class Body
{
    /**
     * @var ContentType
     */
    private $contentType;

    /**
     * @var string
     */
    private $text;

    public function __construct(ContentType $contentType, $text)
    {
        $this->contentType = $contentType;

        Assertion::string($text);
        $this->text = $text;
    }

    public function __toString()
    {
        return $this->text;
    }

    public function contentType()
    {
        return $this->contentType;
    }
}
