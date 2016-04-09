<?php

namespace AMQPIntegrationPatterns\Serialization\Encoding;

interface Encoder
{
    /**
     * @param array $data
     * @return string
     * @throws CouldNotEncodeData
     */
    public function encode(array $data);
}
