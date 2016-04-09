<?php

namespace AMQPIntegrationPatterns\Message;

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
        return Message::create(
            MessageIdentifier::random(),
            new Body($this->contentType, $body)
        );
    }
}
