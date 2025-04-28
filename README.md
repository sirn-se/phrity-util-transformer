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

## Type transformers

- **BasicTypeConverter** - Support transforming all PHP types to all other types
- **EnumConverter** - Transform Enums to string
- **ReadableConverter** - Transform booleans and null to readable strings
- **StringableConverter** - Transform stringable objects to string
- **ThrowableConverter** - Transform throwable to object, array or string
- **ThrowableConverter** - Transform throwable to object, array or string

## Utility resolvers

- **FirstMatchResolver** - Collection of transformers that will use first compatible transformer for transformation
- **RecursionResolver** - Will apply transformer recursively

# Versions

| Version | PHP | |
| --- | --- | --- |
| `1.0` | `^8.1` | Initial version |
