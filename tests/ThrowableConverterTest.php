<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    ThrowableConverter,
    TransformerException,
    Type,
};

/**
 * Transformer test class.
 */
class ThrowableConverterTest extends TestCase
{
    public function testThrowableConverter(): void
    {
        $subject = new LogicException('Error message', 123, new LogicException('Previous error', 456));
        $transformer = new ThrowableConverter();
        $this->assertEquals((object)[
            'type' => 'LogicException',
            'message' => 'Error message',
            'code' => 123,
        ], $transformer->transform($subject));
        $this->assertSame([
            'type' => 'LogicException',
            'message' => 'Error message',
            'code' => 123,
        ], $transformer->transform($subject, Type::ARRAY));
        $this->assertSame('Error message', $transformer->transform($subject, Type::STRING));
        $this->assertFalse($transformer->canTransform($subject, Type::INTEGER));
        $this->assertFalse($transformer->canTransform('A string', Type::STRING));
    }

    public function testThrowableConverterAllData(): void
    {
        $subject = new LogicException('Error message', 123, new LogicException('Previous error', 456));
        $transformer = new ThrowableConverter(
            parts: ['type', 'message', 'code', 'file', 'line', 'trace', 'previous', 'ignored']
        );
        $result = $transformer->transform($subject);
        $this->assertSame('LogicException', $result->type);
        $this->assertSame('Error message', $result->message);
        $this->assertSame(123, $result->code);
        $this->assertStringEndsWith('ThrowableConverterTest.php', $result->file);
        $this->assertIsInt($result->line);
        $this->assertIsArray($result->trace);
        $this->assertInstanceOf(LogicException::class, $result->previous);
    }

    public function testThrowableConverterUnsupported(): void
    {
        $transformer = new ThrowableConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Throwable conversion for 'string' is not supported.");
        $transformer->transform('A string');
    }

    public function testThrowableConverterInvalidDefault(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid 'integer' provided");
        /* @phpstan-ignore argument.type */
        $transformer = new ThrowableConverter(default: Type::INTEGER);
    }
}
