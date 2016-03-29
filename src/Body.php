<?php

namespace AMQPIntegrationPatterns;

use Assert\Assertion;

final class Body
{
    /**
     * @var ContentType
     */
    private $contentType;

    /**
     * @var string
     */
    private $text;

    public function __construct(ContentType $contentType, $data)
    {
        $this->contentType = $contentType;

        Assertion::string($data);
        $this->text = $data;
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
