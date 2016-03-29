<?php

namespace AMQPIntegrationPatterns\Serialization;

interface Normalizer
{
    /**
     * @param CanBeNormalized $object
     * @return array Normalized data
     * @throws CouldNotNormalizeObject
     */
    public function normalize(CanBeNormalized $object);

    /**
     * @param string $className A class that implements CanBeDenormalized
     * @param array $data The data to be used for reconstructing the object of type $class
     * @return object of type $class
     */
    public function denormalize($className, array $data);
}
