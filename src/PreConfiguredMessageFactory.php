<?php

namespace AMQPIntegrationPatterns;

class PreConfiguredMessageFactory implements MessageFactory
{
    /**
     * @var ContentType
     */
    private $contentType;

    public function __construct(ContentType $contentType)
    {
        $this->contentType = $contentType;
    }

    public function createMessageWithBody($body)
    {
        return EventMessage::create(
            MessageIdentifier::random(),
            new Body($this->contentType, $body)
        );
    }
}
