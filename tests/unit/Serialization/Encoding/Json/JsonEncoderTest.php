<?php

namespace AMQPIntegrationPatterns\Tests\Unit\Serialization\Encoding\Json;

use AMQPIntegrationPatterns\Message\Body;
use AMQPIntegrationPatterns\Message\ContentType;
use AMQPIntegrationPatterns\Serialization\Encoding\CouldNotDecodeData;
use AMQPIntegrationPatterns\Serialization\Encoding\CouldNotEncodeData;
use AMQPIntegrationPatterns\Serialization\Encoding\Json\JsonEncoder;

class JsonEncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonEncoder
     */
    private $jsonEncoder;

    protected function setUp()
    {
        $this->jsonEncoder = new JsonEncoder();
    }

    /**
     * @test
     */
    public function it_encodes_structured_data()
    {
        $originalData = ['field' => 'value'];

        $encodedData = $this->jsonEncoder->encode($originalData);

        $this->assertEquals(
            '{"field":"value"}',
            $encodedData
        );
    }

    /**
     * @test
     */
    public function it_decodes_a_message_body()
    {
        $body = new Body(ContentType::json(), '{"field":"value"}');
        $decodedData = $this->jsonEncoder->decode($body);

        $this->assertSame(['field' => 'value'], $decodedData);
    }

    /**
     * @test
     */
    public function it_fails_when_data_could_not_be_encoded()
    {
        $this->setExpectedException(CouldNotEncodeData::class, 'JSON encoding error: "Type is not supported"');
        
        $this->jsonEncoder->encode(array(fopen(__FILE__, 'r')));
    }

    /**
     * @test
     */
    public function it_fails_when_data_could_not_be_decoded()
    {
        $this->setExpectedException(CouldNotDecodeData::class, 'JSON decoding error: "unexpected end of data"');

        $this->jsonEncoder->decode(new Body(ContentType::json(), '["'));
    }

    /**
     * @test
     */
    public function it_fails_when_decoded_data_is_not_an_array()
    {
        $this->setExpectedException(CouldNotDecodeData::class, 'Decoded data is not an array');

        $this->jsonEncoder->decode(new Body(ContentType::json(), '"a string"'));
    }

    /**
     * @test
     */
    public function it_fails_when_normalized_content_type_is_not_json()
    {
        $this->setExpectedException(CouldNotDecodeData::class, 'Normalized content type should be application/json');

        $this->jsonEncoder->decode(new Body(ContentType::xml(), '<some-xml/>'));
    }
}
