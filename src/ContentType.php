<?php


namespace AMQPIntegrationPatterns;


use Assert\Assertion;

final class ContentType
{
    private $textualContentType;

    const CONTENT_TYPE_XML = 'application/xml';

    const CONTENT_TYPE_JSON = 'application/json';

    const CONTENT_TYPE_PLAIN_TEXT = 'text/plain';

    public function __construct($textualContentType)
    {
        Assertion::string($textualContentType);
        Assertion::notEmpty($textualContentType);

        $this->textualContentType = $textualContentType;
    }

    public static function plainText()
    {
        return new self(self::CONTENT_TYPE_PLAIN_TEXT);
    }

    public static function json()
    {
        return new self(self::CONTENT_TYPE_JSON);
    }

    public static function xml()
    {
        return new self(self::CONTENT_TYPE_XML);
    }

    public function __toString()
    {
        return $this->textualContentType;
    }
}
