[Documentation](../../README.md) / Chained Resolver

## Introduction

The `ChainedResolver` takes a list of transformers, passing output from one into the next one.

## Using the converter

```php
$resolver = new ChainedResolver([
    new EnumConverter(),
    new ReadableConverter(),
    new ThrowableConverter(),
    new StringableConverter(),
    new BasicTypeConverter(),
]);

// Convert using chained transformer
$resolver->canTransform($input); // -> bool
$resolver->transform($input); // -> converted output

// Convert to other types
$resolver->canTransform($input, Type::STRING); // -> bool
$resolver->transform($input, Type::STRING); // -> string output

// Force type conversion
$resolver = new ChainedResolver([
    new EnumConverter(),
    new ReadableConverter(),
    new ThrowableConverter(),
    new StringableConverter(),
    new BasicTypeConverter(),
], Type::STRING);
$resolver->canTransform($input); // -> bool
$resolver->transform($input); // -> string output
```
