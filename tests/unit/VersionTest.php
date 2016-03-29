<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\InvalidVersion;
use AMQPIntegrationPatterns\Version;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_represents_a_semver_formatted_version_number()
    {
        $version = Version::fromString('1.2.3');
        $this->assertEquals('1.2.3', (string) $version);
    }

    /**
     * @test
     */
    public function it_fails_if_the_version_number_has_an_invalid_format()
    {
        $this->setExpectedException(
            InvalidVersion::class,
            'Value "a.b.c" is not a correctly formatted version number'
        );

        Version::fromString('a.b.c');
    }
}
