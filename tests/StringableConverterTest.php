<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    StringableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class StringableConverterTest extends TestCase
{
    public function testStringableConverter(): void
    {
        $transformer = new StringableConverter();
        $this->assertSame('Stringable test class', $transformer->transform(new TestStringableObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestStringableObject()));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
    }

    public function testStringableConverterUsingDefault(): void
    {
        $transformer = new StringableConverter(perDefault: true);
        $this->assertSame('Stringable test class', $transformer->transform(new TestStringableObject()));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestStringableObject(), Type::ARRAY));
    }

    public function testStringableConverterUnsupported(): void
    {
        $transformer = new StringableConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Creating stringable for 'string' is not supported.");
        $transformer->transform('A string');
    }
}
