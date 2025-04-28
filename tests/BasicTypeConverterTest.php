<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use LogicException;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    BasicTypeConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class BasicTypeConverterTest extends TestCase
{
    public function testBasicTypeConverter(): void
    {
        $transformer = new BasicTypeConverter();

        $subject = 'A string'; // String
        $this->assertSame('A string', $transformer->transform($subject));
        $this->assertSame(['A string'], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(0, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(0.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['scalar' => 'A string'], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('A string', $transformer->transform($subject, Type::STRING));

        $subject = 123.456; // Float
        $this->assertSame(123.456, $transformer->transform($subject));
        $this->assertSame([123.456], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(123, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(123.456, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['scalar' => 123.456], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('123.456', $transformer->transform($subject, Type::STRING));

        $subject = 789; // Int
        $this->assertSame(789, $transformer->transform($subject));
        $this->assertSame([789], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(789, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(789.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['scalar' => 789], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('789', $transformer->transform($subject, Type::STRING));

        $subject = true; // Bool (true)
        $this->assertSame(true, $transformer->transform($subject));
        $this->assertSame([true], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['scalar' => true], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('1', $transformer->transform($subject, Type::STRING));

        $subject = false; // Bool (false)
        $this->assertSame(false, $transformer->transform($subject));
        $this->assertSame([false], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(false, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(0, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(0.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['scalar' => false], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('', $transformer->transform($subject, Type::STRING));

        $subject = null; // Null
        $this->assertSame(null, $transformer->transform($subject));
        $this->assertSame([], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(false, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(0, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(0.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)[], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('', $transformer->transform($subject, Type::STRING));

        $subject = [1, 'a']; // Array (non-empty)
        $this->assertSame([1, 'a'], $transformer->transform($subject));
        $this->assertSame([1, 'a'], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)[0 => 1, 1 => 'a'], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('array', $transformer->transform($subject, Type::STRING));

        $subject = []; // Array (empty)
        $this->assertSame([], $transformer->transform($subject));
        $this->assertSame([], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(false, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(0, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(0.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)[], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('array', $transformer->transform($subject, Type::STRING));

        $subject = (object)['a' => 1, 'b' => 2]; // Object (stdClass)
        $this->assertEquals((object)['a' => 1, 'b' => 2], $transformer->transform($subject));
        $this->assertSame(['a' => 1, 'b' => 2], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['a' => 1, 'b' => 2], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('stdClass', $transformer->transform($subject, Type::STRING));

        $subject = new TestObject(); // Object (class)
        $this->assertEquals((object)['public' => 'public'], $transformer->transform($subject));
        $this->assertSame(['public' => 'public'], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['public' => 'public'], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('Phrity\Util\Transformer\Test\TestObject', $transformer->transform($subject, Type::STRING));

        $subject = TestBasicEnum::Yes;
        $this->assertEquals((object)['name' => 'Yes'], $transformer->transform($subject));
        $this->assertSame(['name' => 'Yes'], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['name' => 'Yes'], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame(
            'Phrity\Util\Transformer\Test\TestBasicEnum',
            $transformer->transform($subject, Type::STRING)
        );

        $subject = TestBackedEnum::Yes;
        $this->assertEquals((object)['name' => 'Yes', 'value' => 'Jajemen'], $transformer->transform($subject));
        $this->assertSame(['name' => 'Yes', 'value' => 'Jajemen'], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals(
            (object)['name' => 'Yes', 'value' => 'Jajemen'],
            $transformer->transform($subject, Type::OBJECT)
        );
        $this->assertSame(
            'Phrity\Util\Transformer\Test\TestBackedEnum',
            $transformer->transform($subject, Type::STRING)
        );

        $subject = new LogicException('Error message', 123);
        $this->assertEquals((object)[], $transformer->transform($subject));
        $this->assertSame([], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(1, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(1.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)[], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('LogicException', $transformer->transform($subject, Type::STRING));

        $subject = gzopen(sys_get_temp_dir() . '/test-temp.gz', 'w'); // Respurce
        $this->assertEquals('resource (stream)', $transformer->transform($subject));
        $this->assertSame(['resource (stream)'], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame(true, $transformer->transform($subject, Type::BOOLEAN));
        $this->assertSame(0, $transformer->transform($subject, Type::INTEGER));
        $this->assertSame(null, $transformer->transform($subject, Type::NULL));
        $this->assertSame(0.0, $transformer->transform($subject, Type::NUMBER));
        $this->assertEquals((object)['scalar' => 'resource (stream)'], $transformer->transform($subject, Type::OBJECT));
        $this->assertSame('resource (stream)', $transformer->transform($subject, Type::STRING));
    }

    public function testBasicTypeConverterWithMap(): void
    {
        $transformer = new BasicTypeConverter([
            Type::ARRAY => Type::OBJECT,
            Type::OBJECT => Type::ARRAY,
            Type::BOOLEAN => Type::STRING,
            Type::INTEGER => Type::STRING,
            Type::NULL => Type::STRING,
            Type::NUMBER => Type::STRING,
            Type::STRING => Type::BOOLEAN,
        ]);
        $this->assertSame(true, $transformer->transform('A string'));
        $this->assertSame('123.456', $transformer->transform(123.456));
        $this->assertSame('789', $transformer->transform(789));
        $this->assertSame('1', $transformer->transform(true));
        $this->assertSame('', $transformer->transform(null));
        $this->assertEquals((object)[1, 'a'], $transformer->transform([1, 'a']));
        $this->assertEquals(['a' => 1, 'b' => 2], $transformer->transform((object)['a' => 1, 'b' => 2]));
    }

    public function testBasicTypeConverterUnsupportedType(): void
    {
        $transformer = new BasicTypeConverter();
        $subject = 'A string';
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Converting 'string' to 'Invalid type' is not supported.");
        $transformer->transform($subject, 'Invalid type');
    }
}
