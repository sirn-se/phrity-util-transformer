<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    BasicTypeConverter,
    ChainedResolver,
    ReadableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class ChainedResolverTest extends TestCase
{
    public function testChainedResolver(): void
    {
        $transformer = new ChainedResolver([
            new ReadableConverter(),
            new BasicTypeConverter(),
        ], Type::STRING);
        $this->assertEquals('true', $transformer->transform(true));
        $this->assertEquals('true', $transformer->transform(true, Type::STRING));
        $this->assertTrue($transformer->canTransform(true));
        $this->assertTrue($transformer->canTransform(true, Type::STRING));
    }

    public function testChainedResolverInvalidTransformer(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'string' is not implementing Phrity\Util\Transformer\TransformerInterface");
        /* @phpstan-ignore argument.type */
        $transformer = new ChainedResolver(['This is highly illegal']);
    }

    public function testChainedResolverNoMatch(): void
    {
        $transformer = new ChainedResolver([new ReadableConverter()]);
        $this->assertFalse($transformer->canTransform(true, Type::ARRAY));
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Could not find transformer for 'boolean'.");
        $transformer->transform(true, Type::ARRAY);
    }
}
