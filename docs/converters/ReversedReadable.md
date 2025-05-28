[Documentation](../../README.md) / Reversed Readable Converter

## Introduction

The `ReversedReadableConverter` converts some strings to Boolean or Null.

## Using the converter

```php
$converter = new ReversedReadableConverter();

// Can only convert some strings
$converter->canTransform("true", Type::BOOLEAN); // -> true
$converter->canTransform("false", Type::BOOLEAN); // -> false
$converter->canTransform("null", Type::NULL); // -> true
```

## Type conversion examples

| Input | Type: Boolean | Type: Null |
|-|-|-|
| `"true"` | `true` | - |
| `"1"` | `true` | - |
| `"false"` | `false` | - |
| `"0"` | `false` | - |
| `""` | `false` | `null` |
| `"null"` | - | `null` |
