<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp\Fabric;

use AMQPIntegrationPatterns\Amqp\Fabric\QueueName;

class QueueNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_represents_a_valid_queue_name()
    {
        $name = 'all_events';
        $queueName = new QueueName($name);
        $this->assertEquals($name, (string) $queueName);
    }

    /**
     * @test
     */
    public function it_fails_if_a_queue_name_contains_invalid_characters()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new QueueName('dots.are.not.allowed');
    }
}
