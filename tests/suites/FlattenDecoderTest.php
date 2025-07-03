<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    FlattenDecoder,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class FlattenDecoderTest extends TestCase
{
    public function testFlattened(): void
    {
        $flattened = [
            'a1_b1_c1' => 111,
            'a1_b1_c2' => 112,
            'a2' => 2,
        ];
        $transformer = new FlattenDecoder('_');
        $expected = [
            'a1' => [
                'b1' => [
                    'c1' => 111,
                    'c2' => 112,
                ],
            ],
            'a2' => 2,
        ];
        $this->assertTrue($transformer->canTransform($flattened));
        $this->assertSame($expected, $transformer->transform($flattened));
        $this->assertTrue($transformer->canTransform($flattened, Type::ARRAY));
        $this->assertSame($expected, $transformer->transform($flattened, Type::ARRAY));
        $this->assertFalse($transformer->canTransform($flattened, Type::STRING));
        $this->assertFalse($transformer->canTransform('a string'));
    }

    public function testNoSeparator(): void
    {
        $flattened = [
            'a1_b1_c1' => 111,
            'a1_b1_c2' => 112,
            'a2' => 2,
        ];
        $transformer = new FlattenDecoder('');
        $this->assertSame($flattened, $transformer->transform($flattened));
    }
}
