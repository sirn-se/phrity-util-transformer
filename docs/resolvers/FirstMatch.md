[Documentation](../../README.md) / First Match Resolver

## Introduction

The `FirstMatchResolver` takes a list of transformers, and use the first transformer that are able to transform an input.

## Using the converter

You typically add the `BasicTypeConverter` last, in case any other transformer can not apply.

```php
$resolver = new FirstMatchResolver([
    new EnumConverter(),
    new ReadableConverter(),
    new ThrowableConverter(),
    new StringableConverter(),
    new BasicTypeConverter(),
]);

// Convert using first match transformer
$resolver->canTransform($input); // -> bool
$resolver->transform($input); // -> converted output

// Convert to other types
$resolver->canTransform($input, Type::STRING); // -> bool
$resolver->transform($input, Type::STRING); // -> string output

// Force type conversion
$resolver = new FirstMatchResolver([
    new EnumConverter(),
    new ReadableConverter(),
    new ThrowableConverter(),
    new StringableConverter(),
    new BasicTypeConverter(),
], Type::STRING);
$resolver->canTransform($input); // -> bool
$resolver->transform($input); // -> string output
```
