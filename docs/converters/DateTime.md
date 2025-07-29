[Documentation](../../README.md) / DateTime Converter

## Introduction

The `DateTime` converts DateTime related classes to string.
Convertable classes are DateTimeInterface (DateTime and DateTimeImmutable), DateTimeZone, DateInterval and DatePeriod.

## Using the converter

```php
$converter = new DateTime();

$converter->canTransform(new DateTime('2025-07-29 14:13')); // -> bool
$converter->transform(new DateTime('2025-07-29 14:13')); // -> string output

$converter->canTransform(new DateTimeZone('Europe/London')); // -> bool
$converter->transform(new DateTimeZone('Europe/London')); // -> string output

$converter->canTransform(new DateInterval('P1W2D')); // -> bool
$converter->transform(new DateInterval('P1W2D')); // -> string output

$converter->canTransform(new DatePeriod(new DateTime('2025-07-29 12:34'), new DateInterval('P1D'), 2)); // -> bool
$converter->transform(new DatePeriod(new DateTime('2025-07-29 12:34'), new DateInterval('P1D'), 2)); // -> string output
```

## Formatting

The `dateTimeFormat` specifies formatting of date-times.
See [format param](https://www.php.net/manual/en/datetime.format.php#refsect1-datetime.format-parameters) of DateTime class.
Default format is `c` (ISO 8601).

```php
$converter = new DateTime(dateTimeFormat: 'M d, Y');
$converter->transform(new DateTime('2025-07-29 14:13')); // -> string output
$converter->transform(new DatePeriod(new DateTime('2025-07-29 12:34'), new DateInterval('P1D'), 2)); // -> string output
```

The `dateIntervalFormat` specifies formatting of date-intervals.
See [format param](https://www.php.net/manual/en/dateinterval.format.php#refsect1-dateinterval.format-parameters) of DateInterval class.
Default format is `%d` (number of days).

```php
$converter = new DateTime(dateIntervalFormat: '%R%d days');
$converter->transform(new DateInterval('P1W2D')); // -> string output
$converter->transform(new DatePeriod(new DateTime('2025-07-29 12:34'), new DateInterval('P1D'), 2)); // -> string output
```
