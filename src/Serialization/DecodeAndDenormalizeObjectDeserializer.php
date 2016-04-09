<?php

namespace AMQPIntegrationPatterns\Serialization;

use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Serialization\Encoding\Decoder;
use AMQPIntegrationPatterns\Serialization\Normalization\Denormalizer;
use AMQPIntegrationPatterns\Serialization\Normalization\Normalizer;

class DecodeAndDenormalizeObjectDeserializer implements Deserializer
{
    /**
     * @var Decoder
     */
    private $decoder;

    /**
     * @var Normalizer
     */
    private $denormalizer;

    /**
     * @var string
     */
    private $className;

    public function __construct(Decoder $decoder, Denormalizer $denormalizer, $className)
    {
        $this->denormalizer = $denormalizer;
        $this->decoder = $decoder;
        $this->className = $className;
    }

    public function deserialize(Message $message)
    {
        $decodedData = $this->decoder->decode($message->body());
        
        return $this->denormalizer->denormalize($this->className, $decodedData);
    }
}
