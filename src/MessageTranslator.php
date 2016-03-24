<?php

namespace AMQPIntegrationPatterns;

class MessageTranslator implements Receiver
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var MessageChannel
     */
    private $channel;

    public function __construct(Translator $translator, MessageChannel $channel)
    {
        $this->channel = $channel;
        $this->translator = $translator;
    }

    public function process(Message $message)
    {
        $translatedMessage = $this->translator->translate($message);
        $this->channel->publish($translatedMessage);
    }
}
