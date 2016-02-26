<?php

namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\Simple;

class SimpleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_autoloads()
    {
        $simple = new Simple();
    }
}
