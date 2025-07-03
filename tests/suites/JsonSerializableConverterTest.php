<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    JsonSerializableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class JsonSerializableConverterTest extends TestCase
{
    public function testJsonSerializableConverterString(): void
    {
        $testClass = new TestJsonSerializableObject('a string');
        $transformer = new JsonSerializableConverter();
        $this->assertSame('a string', $transformer->transform($testClass));
        $this->assertTrue($transformer->canTransform($testClass));
        $this->assertSame('a string', $transformer->transform($testClass, Type::STRING));
        $this->assertTrue($transformer->canTransform($testClass, Type::STRING));
        $this->assertFalse($transformer->canTransform($testClass, Type::ARRAY));
    }

    public function testJsonSerializableConverterArray(): void
    {
        $testClass = new TestJsonSerializableObject(['an array']);
        $transformer = new JsonSerializableConverter();
        $this->assertSame(['an array'], $transformer->transform($testClass));
        $this->assertTrue($transformer->canTransform($testClass));
        $this->assertSame(['an array'], $transformer->transform($testClass, Type::ARRAY));
        $this->assertTrue($transformer->canTransform($testClass, Type::ARRAY));
        $this->assertFalse($transformer->canTransform($testClass, Type::STRING));
    }

    public function testJsonSerializableInvalid(): void
    {
        $testClass = new TestStringableObject();
        $transformer = new JsonSerializableConverter();
        $this->assertFalse($transformer->canTransform($testClass));
    }

    public function testJsonSerializableError(): void
    {
        $transformer = new JsonSerializableConverter();
        $testClass = new TestJsonSerializableObject(['an array']);
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage(
            "JSON serialize for 'Phrity\Util\Transformer\Test\TestJsonSerializableObject' is not supported."
        );
        $transformer->transform($testClass, 'Invalid type');
    }
}
