<?php

namespace AMQPIntegrationPatterns\Tests\Integration\LongRunning;

use Matthias\PhpUnitAsynchronicity\Eventually;
use Symfony\Component\Process\Process;

class PidFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider stopSignals
     * @param integer $signal
     */
    public function it_creates_a_pid_file_containing_the_current_process_id_and_deletes_it_when_terminating($signal)
    {
        $pidFilePath = __DIR__ . '/long_running_script.php.pid';
        $process = new Process('exec php ' . __DIR__.'/long_running_script.php ' . escapeshellarg($pidFilePath));
        $process->start();

        if (file_exists($pidFilePath)) {
            unlink($pidFilePath);
        }

        $this->assertThat(
            function() use ($pidFilePath) {
                return file_exists($pidFilePath) && is_numeric(file_get_contents($pidFilePath));
            },
            new Eventually(2000, 100),
            'The PID file was never created'
        );

        posix_kill(file_get_contents($pidFilePath), $signal);

        $this->assertThat(
            function() use ($pidFilePath) {
                return !file_exists($pidFilePath);
            },
            new Eventually(2000, 100),
            'The PID file was never deleted'
        );
    }

    public function stopSignals()
    {
        return [
            'SIGINT' => [SIGINT],
            'SIGTERM' => [SIGTERM],
        ];
    }
}
