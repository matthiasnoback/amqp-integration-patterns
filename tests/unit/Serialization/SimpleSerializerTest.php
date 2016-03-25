<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization;

use AMQPIntegrationPatterns\Serialization\Deserializable;
use AMQPIntegrationPatterns\Serialization\SimpleSerializer;
use AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles\ImproperlyDeserializingClass;
use AMQPIntegrationPatterns\Tests\Unit\Serialization\TestDoubles\SimpleSerializableClass;

class SimpleSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleSerializer
     */
    private $simpleSerializer;

    protected function setUp()
    {
        $this->simpleSerializer = new SimpleSerializer();
    }

    /**
     * @test
     */
    public function it_serializes_an_object_by_calling_its_serialize_method()
    {
        $value = 'some value';
        $originalObject = new SimpleSerializableClass($value);

        $serializedData = $this->simpleSerializer->serialize($originalObject);
        $deserializedObject = $this->simpleSerializer->deserialize(SimpleSerializableClass::class, $serializedData);
        $this->assertEquals($originalObject, $deserializedObject);
    }

    /**
     * @test
     */
    public function it_fails_if_deserialize_does_not_return_an_object_of_the_proper_type()
    {
        $class = ImproperlyDeserializingClass::class;

        $this->setExpectedException(
            \LogicException::class,
            $class . '::deserialize() did not return an object of type ' . $class
        );

        $this->simpleSerializer->deserialize($class, []);
    }

    /**
     * @test
     */
    public function it_fails_if_the_object_to_be_deserialized_is_not_in_fact_deserializable()
    {
        $class = \stdClass::class;

        $this->setExpectedException(
            \LogicException::class,
            $class . ' should implement ' . Deserializable::class
        );

        $this->simpleSerializer->deserialize($class, []);
    }
}
