<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Amqp;

use AMQPIntegrationPatterns\Amqp\ConsumptionFlag;

class ConsumptionFlagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_represent_acknowledged_messages()
    {
        $integer = ConsumptionFlag::acknowledge()->asInteger();
        $this->assertSame($integer, ConsumptionFlag::MSG_ACK);
    }

    /**
     * @test
     */
    public function it_can_represent_rejected_messages()
    {
        $integer = ConsumptionFlag::reject()->asInteger();
        $this->assertSame($integer, ConsumptionFlag::MSG_REJECT);
    }
}
