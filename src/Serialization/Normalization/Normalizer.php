<?php

namespace AMQPIntegrationPatterns\Serialization\Normalization;

interface Normalizer
{
    /**
     * @param CanBeNormalized $object
     * @return array Normalized data
     * @throws CouldNotNormalizeObject
     */
    public function normalize(CanBeNormalized $object);
}
