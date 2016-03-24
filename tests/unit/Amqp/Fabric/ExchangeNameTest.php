<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Fabric;

use AMQPIntegrationPatterns\Amqp\Fabric\ExchangeName;

class ExchangeNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_represents_a_valid_queue_name()
    {
        $name = 'some_exchange';
        $queueName = new ExchangeName($name);
        $this->assertEquals($name, (string) $queueName);
    }

    /**
     * @test
     */
    public function it_fails_if_an_exchange_name_contains_invalid_characters()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new ExchangeName('dots.are.not.allowed');
    }
}
