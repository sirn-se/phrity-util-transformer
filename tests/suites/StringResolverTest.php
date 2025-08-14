<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use DateTime;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    DateTimeConverter,
    FirstMatchResolver,
    ReadableConverter,
    StringableConverter,
    StringResolver,
    Type,
};

/**
 * Transformer test class.
 */
class StringResolverTest extends TestCase
{
    public function testStringResolver(): void
    {
        $transformer = new StringResolver();

        $transformed = $transformer->transform(12.34);
        $this->assertSame('12.34', $transformed);
        $this->assertTrue($transformer->canTransform(12.34));

        $transformed = $transformer->transform(['apa', 22, ['bepa', true]]);
        $this->assertSame('["apa", 22, ["bepa", 1]]', $transformed);
        $this->assertTrue($transformer->canTransform(['apa', 22, ['bepa', true]]));

        $transformed = $transformer->transform(['a' => 'apa', 'b' => 22, [3 => 'bepa', true]]);
        $this->assertSame('{a: "apa", b: 22, 0: {3: "bepa", 4: 1}}', $transformed);
        $this->assertTrue($transformer->canTransform(['a' => 'apa', 'b' => 22, [3 => 'bepa', true]]));

        $transformed = $transformer->transform((object)['test' => new TestObject()]);
        $this->assertSame('{test: {public: "public"}}', $transformed);
        $this->assertTrue($transformer->canTransform((object)['test' => new TestObject()]));
    }

    public function testExtendedResolver(): void
    {
        $transformer = new StringResolver(new FirstMatchResolver([
            new DateTimeConverter(),
            new ReadableConverter(),
            new StringableConverter(),
        ]));

        $transformed = $transformer->transform(new DateTime('2025-08-14'));
        $this->assertSame('2025-08-14T00:00:00+00:00', $transformed);

        $data = (object)[
            'string' => 'my string',
            'bool:true' => true,
            'bool:false' => false,
            'null' => null,
            'datetime' => new DateTime('2025-08-14'),
            'object' => new TestObject(),
            'stringable' => new TestStringableObject(),
        ];

        $transformed = $transformer->transform($data);
        $expected = '{'
                  . 'string: "my string", bool:true: 1, bool:false: , null: , '
                  . 'datetime: 2025-08-14T00:00:00+00:00, object: {public: "public"}, stringable: {public: "public"}'
                  . '}'
                  ;
        $this->assertSame($expected, $transformed);

        $transformed = $transformer->transform($data, Type::STRING);
        $expected = '{'
                  . 'string: "my string", bool:true: true, bool:false: false, null: null, '
                  . 'datetime: 2025-08-14T00:00:00+00:00, object: {public: "public"}, stringable: Stringable test class'
                  . '}'
                  ;
        $this->assertSame($expected, $transformed);
    }
}
