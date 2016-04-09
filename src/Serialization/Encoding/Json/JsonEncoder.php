<?php

namespace AMQPIntegrationPatterns\Serialization\Encoding\Json;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Serialization\Encoding\CouldNotDecodeData;
use AMQPIntegrationPatterns\Serialization\Encoding\CouldNotEncodeData;
use AMQPIntegrationPatterns\Serialization\Encoding\Decoder;
use AMQPIntegrationPatterns\Serialization\Encoding\Encoder;

class JsonEncoder implements Encoder, Decoder
{
    public function encode(array $data)
    {
        $encodedData = json_encode($data, JSON_OBJECT_AS_ARRAY);

        if ($encodedData === false && json_last_error() !== JSON_ERROR_NONE) {
            throw new CouldNotEncodeData(
                sprintf(
                    'JSON encoding error: "%s"',
                    json_last_error_msg()
                )
            );
        }

        return $encodedData;
    }

    public function decode(Body $body)
    {
        // TODO assert that normalized content type is application/json
        
        $decodedData = json_decode((string) $body, true);

        if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new CouldNotDecodeData(
                sprintf(
                    'JSON decoding error: "%s"',
                    json_last_error_msg()
                )
            );
        }

        if (!is_array($decodedData)) {
            throw new CouldNotDecodeData('Decoded data is not an array');
        }

        return $decodedData;
    }
}
