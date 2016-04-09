<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;

/**
 * TODO rethink object hierarchy
 */
final class EventMessage implements Message
{
    /**
     * @var MessageIdentifier
     */
    private $messageIdentifier;

    /**
     * @var Body
     */
    private $body;

    private function __construct()
    {
    }

    public static function create(MessageIdentifier $messageIdentifier, Body $body)
    {
        $object = new self();
        $object->messageIdentifier = $messageIdentifier;
        $object->body = $body;

        return $object;
    }

    /**
     * @return MessageIdentifier
     */
    public function messageIdentifier()
    {
        return $this->messageIdentifier;
    }

    /**
     * @return Body
     */
    public function body()
    {
        return $this->body;
    }
}
