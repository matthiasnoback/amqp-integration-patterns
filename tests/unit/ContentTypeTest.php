<?php


namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\ContentType;

class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_represents_a_textual_content_type()
    {
        $textualContentType = 'text/plain';
        $contentType = new ContentType($textualContentType);
        $this->assertSame($textualContentType, (string) $contentType);
    }

    /**
     * @test
     */
    public function it_creates_a_plain_text_content_type()
    {
        $contentType = ContentType::plainText();
        $this->assertSame('text/plain', (string) $contentType);
    }

    /**
     * @test
     */
    public function it_creates_a_json_content_type()
    {
        $contentType = ContentType::json();
        $this->assertSame('application/json', (string) $contentType);
    }

    /**
     * @test
     */
    public function it_creates_an_xml_content_type()
    {
        $contentType = ContentType::xml();
        $this->assertSame('application/xml', (string) $contentType);
    }
}
