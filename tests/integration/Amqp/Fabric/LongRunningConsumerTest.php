<?php

namespace AMQPIntegrationPatterns\Tests\Integration\Amqp\Fabric;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * @group functional
 */
class LongRunningConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_waits_for_messages_and_can_be_interrupted()
    {
        $process = new Process('exec php ' . __DIR__ . '/consume.php');
        $process->start();

        // wait for first round of waiting to have started
        sleep(2);

        $this->assertTrue($process->isRunning());

        $process->signal(SIGINT);

        $stoppedConsuming = false;
        $process->wait(function($type, $message) use (&$stoppedConsuming) {
            if (strpos($message, 'Basic.cancel') !== false) {
                $stoppedConsuming = true;
            }
        });

        $this->assertFalse($process->isRunning());
        $this->assertTrue($stoppedConsuming);
    }
}
