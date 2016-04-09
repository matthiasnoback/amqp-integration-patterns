<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization;

use AMQPIntegrationPatterns\Serialization\CanBeDenormalized;
use AMQPIntegrationPatterns\Serialization\CouldNotDenormalizeObject;
use AMQPIntegrationPatterns\Serialization\CouldNotNormalizeObject;
use AMQPIntegrationPatterns\Serialization\SimpleNormalizer;
use AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles\ImproperlyDenormalizingClass;
use AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles\ImproperlyNormalizingClass;
use AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles\SimpleCanBeNormalizedClass;

class SimpleNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleNormalizer
     */
    private $normalizer;

    protected function setUp()
    {
        $this->normalizer = new SimpleNormalizer();
    }

    /**
     * @test
     */
    public function it_normalizes_an_object()
    {
        $value = 'some value';
        $originalObject = new SimpleCanBeNormalizedClass($value);

        $serializedData = $this->normalizer->normalize($originalObject);
        $deserializedObject = $this->normalizer->denormalize(SimpleCanBeNormalizedClass::class, $serializedData);
        $this->assertEquals($originalObject, $deserializedObject);
    }

    /**
     * @test
     */
    public function it_fails_if_the_normalized_data_is_not_an_array()
    {
        $originalObject = new ImproperlyNormalizingClass();

        $this->setExpectedException(
            CouldNotNormalizeObject::class,
            ImproperlyNormalizingClass::class . '::normalize() should return an array'
        );

        $this->normalizer->normalize($originalObject);
    }
    
    /**
     * @test
     */
    public function it_fails_if_it_does_not_return_an_object_of_the_proper_type()
    {
        $class = ImproperlyDenormalizingClass::class;

        $this->setExpectedException(
            \LogicException::class,
            $class . '::denormalize() did not return an object of type ' . $class
        );

        $this->normalizer->denormalize($class, []);
    }

    /**
     * @test
     */
    public function it_fails_if_the_provided_object_does_not_support_denormalization()
    {
        $class = \stdClass::class;

        $this->setExpectedException(
            CouldNotDenormalizeObject::class,
            $class . ' should implement ' . CanBeDenormalized::class
        );

        $this->normalizer->denormalize($class, []);
    }
}
