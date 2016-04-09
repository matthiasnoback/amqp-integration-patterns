<?php

namespace AMQPIntegrationPatterns\Message;

use Assert\Assertion;
use webignition\InternetMediaType\InternetMediaType;
use webignition\InternetMediaType\Parser\Parser;

final class ContentType
{
    const CONTENT_TYPE_XML = 'application/xml';

    const CONTENT_TYPE_JSON = 'application/json';

    const CONTENT_TYPE_PLAIN_TEXT = 'text/plain';

    /**
     * @var InternetMediaType
     */
    private $internetMediaType;

    public function __construct($textualContentType)
    {
        Assertion::string($textualContentType);
        Assertion::notEmpty($textualContentType);

        $this->internetMediaType = (new Parser())->parse($textualContentType);
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

    public static function fromString($contentTypeString)
    {
        return new self($contentTypeString);
    }

    public function __toString()
    {
        return (string) $this->internetMediaType;
    }

    public function parameter($name)
    {
        return $this->internetMediaType->getParameter($name)->getValue();
    }

    public function normalizedContentType()
    {
        $subtype = $this->internetMediaType->getSubtype();
        if (preg_match('/^(.+)\+(.+)$/', $subtype, $matches) === 1) {
            $format = $matches[2];
        } else {
            $format = $subtype;
        }

        return $this->internetMediaType->getType() . '/' . $format;
    }

    public function version()
    {
        return Version::fromString($this->internetMediaType->getParameter('v')->getValue());
    }

    // TODO supply specific subtype (without vendor etc.)
}
