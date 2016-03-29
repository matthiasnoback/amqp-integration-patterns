<?php

namespace AMQPIntegrationPatterns\Serialization;

use AMQPIntegrationPatterns\EndpointForSending;
use AMQPIntegrationPatterns\MessageFactory;
use AMQPIntegrationPatterns\MessageSender;

class EndpointSerializesDataBeforeSending implements EndpointForSending
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var MessageSender
     */
    private $messageSender;

    public function __construct(MessageFactory $messageFactory, Serializer $serializer, MessageSender $messageSender)
    {
        $this->messageFactory = $messageFactory;
        $this->serializer = $serializer;
        $this->messageSender = $messageSender;
    }

    public function send($data)
    {
        $serializedData = $this->serializer->serialize($data);

        $message = $this->messageFactory->createMessageWithBody($serializedData);

        $this->messageSender->send($message);
    }
}
