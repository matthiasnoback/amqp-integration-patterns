<?php

namespace AMQPIntegrationPatterns;

final class EventMessage
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
     * @return Body
     */
    public function body()
    {
        return $this->body;
    }

    public function messageIdentifier()
    {
        return $this->messageIdentifier;
    }
}
