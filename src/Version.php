<?php

namespace AMQPIntegrationPatterns;

use Assert\Assertion;
use Icecave\SemVer\Version as IcecaveVersion;

final class Version
{
    /**
     * @var IcecaveVersion
     */
    private $version;

    private function __construct()
    {
    }

    public static function fromString($versionString)
    {
        Assertion::string($versionString);

        $version = new self();

        try {
            $version->version = IcecaveVersion::parse($versionString);
        } catch (\InvalidArgumentException $previous) {
            throw InvalidVersion::forValue($versionString, $previous);
        }

        return $version;
    }

    public function __toString()
    {
        return $this->version->string();
    }
}
