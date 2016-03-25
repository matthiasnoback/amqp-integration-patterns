<?php

namespace AMQPIntegrationPatterns\Serialization;

interface Serializer
{
    /**
     * @param Serializable $serializable
     * @return array
     */
    public function serialize(Serializable $serializable);

    /**
     * @param string $className A class that implements Deserializable
     * @param array $data The data to be used for reconstructing the object of type $class
     * @return object of type $class
     */
    public function deserialize($className, array $data);
}
