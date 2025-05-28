<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    ReversedReadableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class ReversedReadableConverterTest extends TestCase
{
    public function testReversedReadableConverter(): void
    {
        $transformer = new ReversedReadableConverter();
        $this->assertFalse($transformer->canTransform('No'));
        $this->assertFalse($transformer->canTransform(true));
        $this->assertFalse($transformer->canTransform(null));
        $this->assertTrue($transformer->transform('true', Type::BOOLEAN));
        $this->assertTrue($transformer->transform('true'));
        $this->assertTrue($transformer->transform('1', Type::BOOLEAN));
        $this->assertTrue($transformer->transform('1'));
        $this->assertFalse($transformer->transform('false', Type::BOOLEAN));
        $this->assertFalse($transformer->transform('false'));
        $this->assertFalse($transformer->transform('0', Type::BOOLEAN));
        $this->assertFalse($transformer->transform('0'));
        $this->assertFalse($transformer->transform('', Type::BOOLEAN));
        $this->assertFalse($transformer->transform(''));
        $this->assertNull($transformer->transform('null', Type::NULL));
        $this->assertNull($transformer->transform('null'));
        $this->assertNull($transformer->transform('', Type::NULL));
    }

    public function testReversedReadableConverterUnsupported(): void
    {
        $transformer = new ReversedReadableConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Creating reversed readable for 'string' is not supported.");
        $transformer->transform('No');
    }
}
