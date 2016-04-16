<?php

namespace AMQPIntegrationPatterns\LongRunning;

use Assert\Assertion;

class PidFile
{
    private $path;
    private $pid;

    private function __construct($path, $pid)
    {
        $this->path = $path;
        $this->pid = $pid;

        file_put_contents($this->path, $this->pid);

        register_shutdown_function([$this, 'cleanUp']);
    }

    public static function createForThisProcess($pidFilePath)
    {
        Assertion::string($pidFilePath);

        return new self($pidFilePath, getmypid());
    }

    public function cleanUp()
    {
        unlink($this->path);
    }
}
