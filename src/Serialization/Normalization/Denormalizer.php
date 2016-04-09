<?php

namespace AMQPIntegrationPatterns\Serialization\Normalization;

interface Denormalizer
{
    /**
     * @param string $className A class that implements CanBeDenormalized
     * @param array $data The data to be used for reconstructing the object of type $class
     * @return object of type $class
     */
    public function denormalize($className, array $data);
}
