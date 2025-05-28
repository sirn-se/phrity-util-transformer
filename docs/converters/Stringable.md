[Documentation](../../README.md) / Stringable Converter

## Introduction

The `StringableConverter` converts Object implementing Stringable interface to String.

## Using the converter

```php
$converter = new StringableConverter();

// Can only convert to string
$converter->canTransform($myStringableObject, Type::STRING); // -> bool
$converter->transform($myStringableObject, Type::STRING); // -> string output

// Force string conversion
$converter = new StringableConverter(true);
$converter->canTransform($myStringableObject); // -> bool
$converter->transform($myStringableObject); // -> string output
```

## Type conversion examples

| Input | Type: String |
|-|-|
| `$myStringableObject` | `"As returned by __toString()"` |
