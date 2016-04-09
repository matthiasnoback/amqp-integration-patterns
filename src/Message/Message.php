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

    /**
     * @var array
     */
    private $metadata = [];

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

    public function withMetadata($key, $value)
    {
        $copy = clone $this;
        $copy->metadata[$key] = $value;

        return $copy;
    }

    public function metadata($key)
    {
        if (!array_key_exists($key, $this->metadata)) {
            throw UndefinedMetadata::forKey($key);
        }

        return $this->metadata[$key];
    }
}
