<?php

namespace AMQPIntegrationPatterns\Tests\Unit\TestDoubles;

use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Translator;

class TranslatorStub implements Translator
{
    public $actualMessage;
    private $translatedMessage;

    public function __construct(Message $translatedMessage)
    {
        $this->translatedMessage = $translatedMessage;
    }

    public function translate(Message $message)
    {
        $this->actualMessage = $message;

        return $this->translatedMessage;
    }
}
