<?php

namespace AMQPIntegrationPatterns;

use AMQPIntegrationPatterns\Message\Message;

final class MessageTranslator
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var MessageSender
     */
    private $messageSender;

    public function __construct(Translator $translator, MessageSender $messageSender)
    {
        $this->messageSender = $messageSender;
        $this->translator = $translator;
    }

    public function consume(Message $message)
    {
        $translatedMessage = $this->translator->translate($message);
        
        $this->messageSender->send($translatedMessage);
    }
}
