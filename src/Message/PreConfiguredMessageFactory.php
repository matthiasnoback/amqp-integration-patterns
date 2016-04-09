<?php

namespace AMQPIntegrationPatterns\Message;

use AMQPIntegrationPatterns\EventMessage;
use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\Message\MessageFactory;

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
