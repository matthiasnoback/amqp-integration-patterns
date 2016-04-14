<?php

namespace AMQPIntegrationPatterns\BlockingIo;

interface Blocking
{
    public function wait();

    public function stopWaiting();
}
