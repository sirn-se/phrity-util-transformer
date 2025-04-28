<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    ReadableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class ReadableConverterTest extends TestCase
{
    public function testReadableConverter(): void
    {
        $transformer = new ReadableConverter();
        $this->assertSame('true', $transformer->transform(true, Type::STRING));
        $this->assertSame('false', $transformer->transform(false, Type::STRING));
        $this->assertSame('null', $transformer->transform(null, Type::STRING));
        $this->assertFalse($transformer->canTransform(true));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testReadableConverterUsingDefault(): void
    {
        $transformer = new ReadableConverter(perDefault: true);
        $this->assertSame('true', $transformer->transform(true));
        $this->assertSame('false', $transformer->transform(false));
        $this->assertSame('null', $transformer->transform(null));
        $this->assertFalse($transformer->canTransform(true, Type::ARRAY));
        $this->assertFalse($transformer->canTransform('A string'));
    }

    public function testReadableConverterUnsupported(): void
    {
        $transformer = new ReadableConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Creating readable for 'string' is not supported.");
        $transformer->transform('A string');
    }
}
