<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    DateTimeConverter,
    TransformerException,
    Type,
};
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;

/**
 * Transformer test class.
 */
class DateTimeConverterTest extends TestCase
{
    public function testDateTime(): void
    {
        $dateTime = new DateTime('2025-07-29 12:34');
        $transformer = new DateTimeConverter();
        $this->assertSame('2025-07-29T12:34:00+00:00', $transformer->transform($dateTime));
        $this->assertSame('2025-07-29T12:34:00+00:00', $transformer->transform($dateTime, Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform($dateTime, Type::OBJECT));

        $dateTime = new DateTime('2025-07-29 12:34');
        $transformer = new DateTimeConverter(dateTimeFormat: 'U');
        $this->assertSame('1753792440', $transformer->transform($dateTime));
        $this->assertSame('1753792440', $transformer->transform($dateTime, Type::STRING));
    }

    public function testDateTimeImmutable(): void
    {
        $dateTime = new DateTimeImmutable('2025-07-29 12:34');
        $transformer = new DateTimeConverter();
        $this->assertSame('2025-07-29T12:34:00+00:00', $transformer->transform($dateTime));
        $this->assertSame('2025-07-29T12:34:00+00:00', $transformer->transform($dateTime, Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform($dateTime, Type::OBJECT));

        $dateTime = new DateTimeImmutable('2025-07-29 12:34');
        $transformer = new DateTimeConverter(dateTimeFormat: 'U');
        $this->assertSame('1753792440', $transformer->transform($dateTime));
        $this->assertSame('1753792440', $transformer->transform($dateTime, Type::STRING));
    }

    public function testDateTimeZone(): void
    {
        $timeZone = new DateTimeZone('Europe/London');
        $transformer = new DateTimeConverter();
        $this->assertSame('Europe/London', $transformer->transform($timeZone));
        $this->assertSame('Europe/London', $transformer->transform($timeZone, Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform($timeZone, Type::OBJECT));
    }

    public function testDateInterval(): void
    {
        $dateInterval = new DateInterval('P1W2D');
        $transformer = new DateTimeConverter();
        $this->assertSame('9', $transformer->transform($dateInterval));
        $this->assertSame('9', $transformer->transform($dateInterval, Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform($dateInterval, Type::OBJECT));

        $transformer = new DateTimeConverter(dateIntervalFormat: '%R%d days');
        $this->assertSame('+9 days', $transformer->transform($dateInterval));
        $this->assertSame('+9 days', $transformer->transform($dateInterval, Type::STRING));
    }

    public function testDatePeriod(): void
    {
        $datePeriod = new DatePeriod(new DateTime('2025-07-29 12:34'), new DateInterval('P1D'), 2);
        $transformer = new DateTimeConverter();
        $this->assertSame('2025-07-29T12:34:00+00:00 (1)', $transformer->transform($datePeriod));
        $this->assertSame('2025-07-29T12:34:00+00:00 (1)', $transformer->transform($datePeriod, Type::STRING));
        $this->assertFalse($transformer->canTransform(new TestObject(), Type::STRING));
        $this->assertFalse($transformer->canTransform($datePeriod, Type::OBJECT));

        $transformer = new DateTimeConverter(dateTimeFormat: 'U', dateIntervalFormat: '%R%d days');
        $this->assertSame('1753792440 (+1 days)', $transformer->transform($datePeriod));
        $this->assertSame('1753792440 (+1 days)', $transformer->transform($datePeriod, Type::STRING));
    }

    public function testDateTimeConverterUnsupported(): void
    {
        $transformer = new DateTimeConverter();
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage("Converting 'string' is not supported.");
        $transformer->transform('A string');
    }
}
