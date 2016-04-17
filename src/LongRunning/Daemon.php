<?php

namespace AMQPIntegrationPatterns\LongRunning;

class Daemon
{
    public static function createFromCallable(callable $runInDaemonProcess, callable $runInParentProcess)
    {
        $pid = pcntl_fork();

        if ($pid === -1) {
            throw new \RuntimeException('Could not fork the process');
        }
        elseif ($pid > 0) {
            call_user_func($runInParentProcess, $pid);
        } else {
            call_user_func($runInDaemonProcess);
        }
    }
}
