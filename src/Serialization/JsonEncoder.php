<?php

namespace AMQPIntegrationPatterns\Serialization;

class JsonEncoder implements Encoder
{
    public function encode(array $data)
    {
        $encodedData = json_encode($data, JSON_OBJECT_AS_ARRAY);

        if ($encodedData === false) {
            throw new CouldNotEncodeData(
                sprintf(
                    'JSON encoding error: "%s"',
                    json_last_error_msg()
                )
            );
        }

        return $encodedData;
    }

    public function decode($stringData)
    {
        // TODO catch and test JSON decode error
        return json_decode($stringData, true);
    }
}
