[Documentation](../../README.md) / Json Decoder

## Introduction

The `JsonDecoder` decodes JSON string and return decoded data.

## Using the decoder

```php
// Convert to anything

$decoder = new JsonDecoder();
$decoder->canTransform($json); // -> bool
$decoder->transform($json); // -> mixed output

// Objects decoded as object or associative arrays

$json = '{"int": 1234, "bool": true, "null": null}';
$decoder1 = new JsonDecoder();
$decoder1->transform($json); // -> object output
$decoder2 = new JsonDecoder(true);
$decoder2->transform($json); // -> array output

// Converting to specific type only allowed if decoded value has matching type

$json = '{"int": 1234, "bool": true, "null": null}';
$decoder->canTransform($json, Type::OBJECT); // -> true
$decoder->canTransform($json, Type::STRING); // -> false
```
