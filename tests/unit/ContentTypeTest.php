<?php


namespace AMQPIntegrationPatterns\Tests\Unit;

use AMQPIntegrationPatterns\ContentType;
use AMQPIntegrationPatterns\Version;

class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_represents_a_textual_content_type()
    {
        $textualContentType = 'text/plain';
        $contentType = ContentType::fromString($textualContentType);
        $this->assertSame($textualContentType, (string) $contentType);
    }

    /**
     * @test
     */
    public function it_creates_a_plain_text_content_type()
    {
        $contentType = ContentType::plainText();
        $this->assertSame('text/plain', $contentType->normalizedContentType());
    }

    /**
     * @test
     */
    public function it_creates_a_json_content_type()
    {
        $contentType = ContentType::json();
        $this->assertSame('application/json', $contentType->normalizedContentType());
    }

    /**
     * @test
     */
    public function it_creates_an_xml_content_type()
    {
        $contentType = ContentType::xml();
        $this->assertSame('application/xml', $contentType->normalizedContentType());
    }

    /**
     * @test
     */
    public function it_parses_a_full_media_type()
    {
        $contentType = ContentType::fromString('application/vnd.event.name+json;v=1.2.0');
        $this->assertEquals(Version::fromString('1.2.0'), $contentType->version());
        $this->assertSame('application/json', $contentType->normalizedContentType());
    }
}
