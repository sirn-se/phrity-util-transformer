[Documentation](../../README.md) / Recursion Resolver

## Introduction

The `RecursionResolver` takes a transformer, and applies it recursively on Array and Object output.

## Using the converter

```php
$resolver = new RecursionResolver(
    new BasicTypeConverter()
);

// Convert recursively
$resolver->canTransform($input); // -> bool
$resolver->transform($input); // -> converted output

// Convert to other types
$resolver->canTransform($input, Type::STRING); // -> bool
$resolver->transform($input, Type::STRING); // -> string output
```
