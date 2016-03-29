<?php

namespace AMQPIntegrationPatterns\Serialization;

interface Encoder
{
    /**
     * @param array $data
     * @return string
     * @throws CouldNotEncodeData
     */
    public function encode(array $data);

    /**
     * @param string $stringData
     * @return array Structured data
     */
    public function decode($stringData);
}
