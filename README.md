<p align="center"><img src="docs/logotype.png" alt="Phrity Util Transformer" width="100%"></p>

[![Build Status](https://github.com/sirn-se/phrity-util-transformer/actions/workflows/acceptance.yml/badge.svg)](https://github.com/sirn-se/phrity-util-transformer/actions)
[![Coverage Status](https://coveralls.io/repos/github/sirn-se/phrity-util-transformer/badge.svg?branch=main)](https://coveralls.io/github/sirn-se/phrity-util-transformer?branch=main)

# Introduction

Type transformers, normalizers and resolvers.

## Installation

Install with [Composer](https://getcomposer.org/);
```
composer require phrity/util-transformer
```

# How to use

All transformers exposes `canTransform()` and `transform()` methods.

This allows us to transform data of a certain type to another type.
A specific transformer may not be able to transform all types.

```php
$transformer = new BasicTypeConverter();
if ($transformer->canTransform($subject)) {
    $transformed = transformer->transform($subject);
}
```

As option, a transformer can take a target type specifier as second argument.

```php
$transformer = new BasicTypeConverter();
if ($transformer->canTransform($subject, Type::ARRAY)) {
    $transformed = transformer->transform($subject, Type::ARRAY);
}
```

Utility resolvers enable stacking multiple transformers and performing other tasks.

```php
$transformer = new RecursionResolver(
    new FirstMatchResolver([
        new EnumConverter(),
        new ReadableConverter(),
        new ThrowableConverter(),
        new StringableConverter(),
        new BasicTypeConverter(),
    ])
);
if ($transformer->canTransform($subject, Type::STRING)) {
    $transformed = transformer->transform($subject, Type::STRING);
}
```

# List of transformers in this library

## Encoders & Decoders

- **[Flatten Decoder](docs/codecs/FlattenDecoder.md)** - Expands array with flattened keys to nested array
- **[Json Decoder](docs/codecs/JsonDecoder.md)** - Decodes JSON string

## Type converters

- **[Basic Type](docs/converters/BasicType.md)** - Support transforming all PHP types to all other types
- **[Enum](docs/converters/Enum.md)** - Transform Enums to string
- **[Json Serializable](docs/converters/JsonSerializable.md)** - Transform JSON serializable objects
- **[Readable](docs/converters/Readable.md)** - Transform booleans and null to readable strings
- **[Reversed Readable](docs/converters/ReversedReadable.md)** - Transform some strings to boolean and null
- **[Stringable](docs/converters/Stringable.md)** - Transform stringable objects to string
- **[Throwable](docs/converters/Throwable.md)** - Transform throwable to object, array or string

## Utility resolvers

- **[First Match](docs/resolvers/FirstMatch.md)** - Collection of transformers that will use first compatible transformer for transformation
- **[Recursion](docs/resolvers/Recursion.md)** - Will apply transformer recursively

## Wrappers

- **[Symfony Normalizer](docs/wrappers/SymfonyNormalizerWrapper.md)** - Wrap class implementing Symfony `NormalizerInterface`


# Versions

| Version | PHP | |
| --- | --- | --- |
| `1.2` | `^8.1` | Additional transformers |
| `1.1` | `^8.1` | Additional transformers |
| `1.0` | `^8.1` | Initial version |
