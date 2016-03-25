<?php

namespace AMQPIntegrationPatterns\Serialization;

class SimpleSerializer implements Serializer
{
    public function serialize(Serializable $serializable)
    {
        return $serializable->serialize();
    }

    public function deserialize($className, array $data)
    {
        if (!in_array(Deserializable::class, class_implements($className))) {
            throw new \LogicException(sprintf(
                '%s should implement %s',
                $className,
                Deserializable::class
            ));
        }

        $deserializedObject = call_user_func([$className, 'deserialize'], $data);

        if (!$deserializedObject instanceof $className) {
            throw new \LogicException(sprintf(
                '%1$s::deserialize() did not return an object of type %1$s',
                $className
            ));
        }

        return $deserializedObject;
    }
}
