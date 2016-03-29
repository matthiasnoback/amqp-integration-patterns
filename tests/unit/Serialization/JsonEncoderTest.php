<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization;

use AMQPIntegrationPatterns\Serialization\CouldNotEncodeData;
use AMQPIntegrationPatterns\Serialization\JsonEncoder;

class JsonEncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_encodes_and_decodes_structured_data()
    {
        $jsonEncoder = new JsonEncoder();
        $originalData = ['field' => 'value'];

        $encodedData = $jsonEncoder->encode($originalData);
        $decodedData = $jsonEncoder->decode($encodedData);

        $this->assertSame($originalData, $decodedData);
    }

    /**
     * @test
     */
    public function it_fails_when_data_could_not_be_encoded()
    {
        $jsonEncoder = new JsonEncoder();
        
        $this->setExpectedException(CouldNotEncodeData::class, 'JSON encoding error: "Type is not supported"');
        
        $jsonEncoder->encode(array(fopen(__FILE__, 'r')));
    }
}
