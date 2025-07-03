<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    JsonDecoder,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class JsonDecoderTest extends TestCase
{
    public function testJsonDecoderString(): void
    {
        $json = '"a string"';
        $transformer = new JsonDecoder();
        $this->assertSame('a string', $transformer->transform($json));
        $this->assertTrue($transformer->canTransform($json));
        $this->assertSame('a string', $transformer->transform($json, Type::STRING));
        $this->assertTrue($transformer->canTransform($json, Type::STRING));
        $this->assertFalse($transformer->canTransform($json, Type::ARRAY));
    }

    public function testJsonDecoderArray(): void
    {
        $json = '["an array"]';
        $transformer = new JsonDecoder();
        $this->assertSame(['an array'], $transformer->transform($json));
        $this->assertTrue($transformer->canTransform($json));
        $this->assertSame(['an array'], $transformer->transform($json, Type::ARRAY));
        $this->assertTrue($transformer->canTransform($json, Type::ARRAY));
        $this->assertFalse($transformer->canTransform($json, Type::STRING));
    }

    public function testJsonDecoderObject(): void
    {
        $json = '{"int": 1234, "bool": true, "null": null}';
        $transformer = new JsonDecoder();
        $this->assertEquals(
            (object)['int' => 1234, 'bool' => true, 'null' => null],
            $transformer->transform($json)
        );
        $this->assertTrue($transformer->canTransform($json));
        $this->assertEquals(
            (object)['int' => 1234, 'bool' => true, 'null' => null],
            $transformer->transform($json, Type::OBJECT)
        );
        $this->assertTrue($transformer->canTransform($json, Type::OBJECT));
        $this->assertFalse($transformer->canTransform($json, Type::ARRAY));
    }

    public function testJsonDecoderAssociative(): void
    {
        $json = '{"int": 1234, "bool": true, "null": null}';
        $transformer = new JsonDecoder(true);
        $this->assertEquals(
            ['int' => 1234, 'bool' => true, 'null' => null],
            $transformer->transform($json)
        );
        $this->assertTrue($transformer->canTransform($json));
        $this->assertEquals(
            ['int' => 1234, 'bool' => true, 'null' => null],
            $transformer->transform($json, Type::ARRAY)
        );
        $this->assertTrue($transformer->canTransform($json, Type::ARRAY));
        $this->assertFalse($transformer->canTransform($json, Type::OBJECT));
    }

    public function testInvalidJsonInput(): void
    {
        $json = ['not json-string'];
        $transformer = new JsonDecoder();
        $this->assertFalse($transformer->canTransform($json));

        $json = 'naughty json';
        $transformer = new JsonDecoder();
        $this->assertFalse($transformer->canTransform($json));
    }

    public function testJsonDecoderError(): void
    {
        $transformer = new JsonDecoder();
        $json = '123';
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("JSON decoding for '123' is not supported.");
        $transformer->transform($json, 'Invalid type');
    }
}
