[Documentation](../../README.md) / JsonSerializable Converter

## Introduction

The `JsonSerializableConverter` converts Object implementing JsonSerializable interface.

## Using the converter

```php
$converter = new JsonSerializableConverter();

// Convert to anything
$converter->canTransform($myJsonSerializableObject); // -> bool
$converter->transform($myJsonSerializableObject); // -> mixed output

// Converting to specific type only allowed if encoded value has matching type
$converter->canTransform($myJsonSerializableObject, Type::STRING); // -> bool
$converter->transform($myJsonSerializableObject, Type::STRING); // -> string output (or exception)
```
