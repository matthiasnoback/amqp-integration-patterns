<?php

namespace AMQPIntegrationPatterns\BlockingIo;

interface BlocksWhileWaiting
{
    public function wait();

    public function stopWaiting();
}
