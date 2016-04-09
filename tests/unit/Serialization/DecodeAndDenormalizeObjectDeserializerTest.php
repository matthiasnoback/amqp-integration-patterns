<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Message\Message;
use AMQPIntegrationPatterns\Message\MessageIdentifier;
use AMQPIntegrationPatterns\Serialization\DecodeAndDenormalizeObjectDeserializer;
use AMQPIntegrationPatterns\Serialization\Encoding\Decoder;
use AMQPIntegrationPatterns\Serialization\Normalization\Denormalizer;

class DecodeAndDenormalizeObjectDeserializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_decodes_and_denormalizes_an_object()
    {
        $message = Message::create(MessageIdentifier::random(), new Body(ContentType::json(), 'the raw data'));
        $className = 'TheClassName';

        $decoder = $this->prophesize(Decoder::class);
        $decodedData = ['decoded' => 'data'];
        $decoder->decode($message->body())->willReturn($decodedData);

        $denormalizer = $this->prophesize(Denormalizer::class);
        $denormalizedObject = new \stdClass();
        $denormalizer->denormalize($className, $decodedData)->willReturn($denormalizedObject);
        
        $deserializer = new DecodeAndDenormalizeObjectDeserializer(
            $decoder->reveal(),
            $denormalizer->reveal(),
            $className
        );

        $deserializedObject = $deserializer->deserialize($message);
        
        $this->assertSame(
            $denormalizedObject,
            $deserializedObject
        );
    }
}
