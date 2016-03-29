<?php

namespace AMQPIntegrationPatterns\Serialization;

class SimpleNormalizer implements Normalizer
{
    public function normalize(CanBeNormalized $object)
    {
        $normalizedData = $object->normalize();

        if (!is_array($normalizedData)) {
            throw new \LogicException(
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
        if (!in_array(CanBeDenormalized::class, class_implements($className))) {
            throw new \LogicException(sprintf(
                '%s should implement %s',
                $className,
                CanBeDenormalized::class
            ));
        }

        $denormalizedObject = call_user_func([$className, 'denormalize'], $data);

        if (!$denormalizedObject instanceof $className) {
            throw new \LogicException(sprintf(
                '%1$s::denormalize() did not return an object of type %1$s',
                $className
            ));
        }

        return $denormalizedObject;
    }
}
