[Documentation](../../README.md) / String Resolver

## Introduction

The `StringResolver` fold anything to a string. Add additional transformers for specific type conversions.

## Using the converter

```php
$resolver = new StringResolver();

// Convert to string

$resolver->canTransform($input); // -> true
$resolver->transform($input); // -> string output

// Tell underlying converters what to do

$resolver->canTransform($input, Type::STRING); // -> true
$resolver->transform($input, Type::STRING); // -> string output

$resolver->canTransform($input, Type::ARRAY); // -> true
$resolver->transform($input, Type::ARRAY); // -> string output

// Add transformers

$resolver = new StringResolver(new FirstMatchResolver([
    new DateTimeConverter(),
    new ReadableConverter(),
    new StringableConverter(),
]));
$resolver->canTransform($input); // -> true
$resolver->transform($input); // -> string output
```
