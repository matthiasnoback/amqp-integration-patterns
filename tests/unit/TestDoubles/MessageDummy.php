<?php

namespace AMQPIntegrationPatterns\Tests\Unit\TestDoubles;

use AMQPIntegrationPatterns\Message\Message;

class MessageDummy implements Message
{
    public function messageIdentifier()
    {
    }

    public function body()
    {
    }
}
