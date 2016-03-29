<?php

namespace AMQPIntegrationPatterns\Serialization;

class NormalizeAndEncodeObjectSerializer implements Serializer
{
    /**
     * @var Normalizer
     */
    private $normalizer;

    /**
     * @var Encoder
     */
    private $encoder;

    public function __construct(Normalizer $normalizer, Encoder $encoder)
    {
        $this->normalizer = $normalizer;
        $this->encoder = $encoder;
    }

    public function serialize($object)
    {
        if (!$object instanceof CanBeNormalized) {
            throw new CouldNotSerializeData(
                sprintf(
                    'The provided data should be an object of type "%s"',
                    CanBeNormalized::class
                )
            );
        }

        $normalizedData = $this->normalizer->normalize($object);

        $encodedData = $this->encoder->encode($normalizedData);

        return $encodedData;
    }
}
