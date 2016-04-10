<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\ProcessIdentifier;

class ProcessIdentifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_generates_a_process_identifier_from_system_globals()
    {
        $processIdentifier = ProcessIdentifier::fromSystemGlobals();
        $this->assertEquals('PHPPROCESS_' . gethostname() . '_' . getmypid(), (string) $processIdentifier);
    }

    /**
     * @test
     */
    public function it_is_possible_to_use_a_custom_process_identifier()
    {
        $processIdentifier = ProcessIdentifier::fromString('some string');
        $this->assertEquals('some string', (string) $processIdentifier);
    }
}
