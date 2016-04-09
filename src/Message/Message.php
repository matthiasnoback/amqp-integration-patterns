<?php

namespace AMQPIntegrationPatterns\Message;

/**
 * TODO add message type and metadata
 */
final class Message
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
