<?php

namespace AMQPIntegrationPatterns\Serialization\Normalization;

use Assert\Assertion;

class SimpleNormalizer implements Normalizer, Denormalizer
{
    public function normalize(CanBeNormalized $object)
    {
        $normalizedData = $object->normalize();

        if (!is_array($normalizedData)) {
            throw new CouldNotNormalizeObject(
                sprintf(
                    '%s::normalize() should return an array',
                    get_class($object)
                )
            );
        }

        return $normalizedData;
    }

    public function denormalize($className, array $data)
    {
        Assertion::string($className);

        if (!class_exists($className)) {
            throw new CouldNotDenormalizeObject(sprintf(
                'Class "%s" does not exist',
                $className,
                CanBeDenormalized::class
            ));
        }

        if (!in_array(CanBeDenormalized::class, class_implements($className))) {
            throw new CouldNotDenormalizeObject(sprintf(
                '%s should implement %s',
                $className,
                CanBeDenormalized::class
            ));
        }

        $denormalizedObject = call_user_func([$className, 'denormalize'], $data);

        if (!$denormalizedObject instanceof $className) {
            throw new CouldNotDenormalizeObject(sprintf(
                '%1$s::denormalize() did not return an object of type %1$s',
                $className
            ));
        }

        return $denormalizedObject;
    }
}
