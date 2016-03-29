<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization;

use AMQPIntegrationPatterns\Serialization\CanBeNormalized;
use AMQPIntegrationPatterns\Serialization\CouldNotNormalizeObject;
use AMQPIntegrationPatterns\Serialization\CouldNotSerializeData;
use AMQPIntegrationPatterns\Serialization\Encoder;
use AMQPIntegrationPatterns\Serialization\NormalizeAndEncodeObjectSerializer;
use AMQPIntegrationPatterns\Serialization\Normalizer;
use AMQPIntegrationPatterns\Serialization\Serializer;
use AMQPIntegrationPatterns\Tests\Integration\Amqp\TestDoubles\NormalizableObject;

class NormalizeAndEncodeObjectSerializerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {

    }
    /**
     * @test
     */
    public function it_normalizes_then_encodes_objects()
    {
        $value = 'some value';

        $dataDummy = $this->prophesize(CanBeNormalized::class)->reveal();

        $normalizedData = ['field' => $value];
        $normalizerMock = $this->prophesize(Normalizer::class);
        $normalizerMock->normalize($dataDummy)->willReturn($normalizedData);

        $encoderMock = $this->prophesize(Encoder::class);
        $encodedData = '{"field":"some value"}';
        $encoderMock->encode($normalizedData)->willReturn($encodedData);

        $serializer = new NormalizeAndEncodeObjectSerializer(
            $normalizerMock->reveal(),
            $encoderMock->reveal()
        );

        $serializedData = $serializer->serialize($dataDummy);

        $this->assertSame($encodedData, $serializedData);
    }

    /**
     * @test
     */
    public function it_fails_when_the_provided_data_is_not_a_normalizable_object()
    {
        $this->setExpectedException(
            CouldNotSerializeData::class,
            'The provided data should be an object of type "' . CanBeNormalized::class . '"'
        );

        $serializer = new NormalizeAndEncodeObjectSerializer(
            $this->prophesize(Normalizer::class)->reveal(),
            $this->prophesize(Encoder::class)->reveal()
        );

        $notANormalizableObject = 'some string';
        $serializer->serialize($notANormalizableObject);
    }
}
