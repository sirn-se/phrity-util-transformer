<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    EnumConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class EnumConverterTest extends TestCase
{
    public function testEnumConverter(): void
    {
        $transformer = new EnumConverter();
        $this->assertSame('Yes', $transformer->transform(TestBasicEnum::Yes, Type::STRING));
        $this->assertSame('No', $transformer->transform(TestBackedEnum::No, Type::STRING));
        $this->assertFalse($transformer->canTransform(TestBasicEnum::Yes));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testEnumConverterUsingDefault(): void
    {
        $transformer = new EnumConverter(perDefault: true);
        $this->assertSame('Yes', $transformer->transform(TestBasicEnum::Yes));
        $this->assertSame('No', $transformer->transform(TestBackedEnum::No));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testEnumConverterUnsupported(): void
    {
        $transformer = new EnumConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Enum string for 'string' is not supported.");
        $transformer->transform('A string');
    }
}
