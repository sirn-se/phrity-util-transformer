<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    BasicTypeConverter,
    RecursionResolver,
    Type,
};

/**
 * Transformer test class.
 */
class RecursionResolverTest extends TestCase
{
    public function testRecursionResolver(): void
    {
        $transformer = new RecursionResolver(new BasicTypeConverter());
        $this->assertSame([
            'a' => [
                'b' => 1,
                'c' => [
                    'd' => 2,
                    'e' => [
                        'public' => 'public',
                    ]
                ]
            ]
        ], $transformer->transform([
            'a' => [
                'b' => 1,
                'c' => [
                    'd' => 2,
                    'e' => new TestObject()
                ]
            ]
        ], Type::ARRAY));
        $this->assertEquals((object)[
            'a' => (object)[
                'b' => 1,
                'c' => (object)[
                    'd' => 2,
                    'e' => (object)[
                        'public' => 'public',
                    ]
                ]
            ]
        ], $transformer->transform((object)[
            'a' => (object)[
                'b' => 1,
                'c' => (object)[
                    'd' => 2,
                    'e' => new TestObject()
                ]
            ]
        ], Type::OBJECT));
        $this->assertTrue($transformer->canTransform('A string'));
        $this->assertSame('A string', $transformer->transform('A string'));
    }
}
