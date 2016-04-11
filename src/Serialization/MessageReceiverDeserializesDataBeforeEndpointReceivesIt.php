<?php

namespace AMQPIntegrationPatterns\Serialization;

use AMQPIntegrationPatterns\ApplicationError;
use AMQPIntegrationPatterns\EndpointForReceiving;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\MessageReceiver;

class MessageReceiverDeserializesDataBeforeEndpointReceivesIt implements MessageReceiver
{
    /**
     * @var Deserializer
     */
    private $deserializer;

    /**
     * @var EndpointForReceiving
     */
    private $endpoint;

    public function __construct(Deserializer $deserializer, EndpointForReceiving $endpoint)
    {
        $this->deserializer = $deserializer;
        $this->endpoint = $endpoint;
    }

    public function receive(Message $message)
    {
        $data = $this->deserializer->deserialize($message);

        try {
            $this->endpoint->accept($data, $message);
        } catch (\Exception $exception) {
            throw ApplicationError::fromException($exception);
        }
    }
}
