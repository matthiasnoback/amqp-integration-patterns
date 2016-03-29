<?php

namespace AMQPIntegrationPatterns;

final class MessageTranslator
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

    public function consume(Message $message)
    {
        $translatedMessage = $this->translator->translate($message);
        $this->channel->send($translatedMessage);
    }
}
