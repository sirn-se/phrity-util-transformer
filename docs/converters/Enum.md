[Documentation](../../README.md) / Enum Converter

## Introduction

The `EnumConverter` converts PHP Enumerations to String.

## Using the converter

```php
$converter = new EnumConverter();

// Can only convert to string
$converter->canTransform($myEnum, Type::STRING); // -> bool
$converter->transform($myEnum, Type::STRING); // -> string output

// Force string conversion
$converter = new EnumConverter(true);
$converter->canTransform($myEnum); // -> bool
$converter->transform($myEnum); // -> string output
```

## Type conversion examples

| Input | Type: String |
|-|-|
| `$unitEnum::Yes` |  `"Yes"` |
| `$backedEnum::No` |  `"No"` |
