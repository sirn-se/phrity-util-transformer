<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    BasicTypeConverter,
    EnumConverter,
    FirstMatchResolver,
    ReadableConverter,
    StringableConverter,
    ThrowableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class FirstMatchResolverTest extends TestCase
{
    public function testFirstMatchResolver(): void
    {
        $subject = new LogicException('Error message', 123);
        $transformer = new FirstMatchResolver([
            new EnumConverter(),
            new ReadableConverter(),
            new ThrowableConverter(),
            new StringableConverter(),
            new BasicTypeConverter(),
        ], Type::STRING);
        $this->assertEquals('Error message', $transformer->transform($subject));
        $this->assertTrue($transformer->canTransform($subject));
        $this->assertSame('Yes', $transformer->transform(TestBasicEnum::Yes));
        $this->assertSame('true', $transformer->transform(true));
        $this->assertSame('Stringable test class', $transformer->transform(new TestStringableObject()));
        $this->assertSame('A string', $transformer->transform('A string'));
    }

    public function testFirstMatchResolverConvertable(): void
    {
        $transformer = new FirstMatchResolver([new StringableConverter()], Type::STRING);
        $this->assertTrue($transformer->canTransform(new TestStringableObject()));
        $this->assertFalse($transformer->canTransform(new TestObject()));
    }

    public function testFirstMatchResolverInvalidTransformer(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'string' is not implementing Phrity\Util\Transformer\TransformerInterface");
        /* @phpstan-ignore argument.type */
        $transformer = new FirstMatchResolver(['This is highly illegal']);
    }

    public function testFirstMatchResolverNoMatch(): void
    {
        $transformer = new FirstMatchResolver([new EnumConverter()]);
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Could not find transformer for 'string'.");
        $transformer->transform('A string');
    }
}
