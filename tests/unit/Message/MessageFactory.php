<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Message;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;

class MessageFactory
{
    public static function createMessageDummy()
    {
        return Message::create(MessageIdentifier::random(), new Body(ContentType::plainText(), 'Hello world'));
    }
}
