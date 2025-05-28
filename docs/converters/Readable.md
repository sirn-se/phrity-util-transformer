[Documentation](../../README.md) / Readable Converter

## Introduction

The `ReadableConverter` converts Boolean and Null to readable String.

## Using the converter

```php
$converter = new ReadableConverter();

// Can only convert to string
$converter->canTransform($myBoolOrNull, Type::STRING); // -> bool
$converter->transform($myBoolOrNull, Type::STRING); // -> string output

// Force string conversion
$converter = new ReadableConverter(true);
$converter->canTransform($myBoolOrNull); // -> bool
$converter->transform($myBoolOrNull); // -> string output
```

## Type conversion examples

| Input | Type: String |
|-|-|
| `true` | `"true"` |
| `false` | `"false"` |
| `null` | `"null"` |
