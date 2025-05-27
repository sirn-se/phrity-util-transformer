[Documentation](../../README.md) / Basic Type Converter

## Introduction

The `BasicTypeConverter` converts using PHP´s internal casting, with a few special cases.

* If input is an Object and output type is Array or Object, `get_object_vars()` is used to extract object variables.
* If input is an Array or Object and output type is String, `get_debug_type()` is used to create string representation

## Using the converter

```php
$converter = new BasicTypeConverter();

// Convert to same type as input
$converter->canTransform($input); // -> bool
$converter->transform($input); // -> converted output

// Convert to other types
$converter->canTransform($input, Type::STRING); // -> bool
$converter->transform($input, Type::STRING); // -> string output
$converter->canTransform($input, Type::ARRAY); // -> bool
$converter->transform($input, Type:: ARRAY); // -> array output

// Default type mapping
$converter = new BasicTypeConverter([
  Type::INTEGER => Type::STRING,
  Type::OBJECT => Type::ARRAY,
]);
$converter->transform(123); // -> string output
$converter->transform($myObject); // -> array output
```

## Type conversion examples

If type is not specified, the converter will keep original type.

| Input | Type: Array | Type: Boolean | Type: Integer | Type: Null | Type: Number | Type: Object | Type: String |
|-|-|-|-|-|-|-|-|
| `"A string"` | `[0: "A string"]` | `true` | `0` | `null` | `0.0` | `{$scalar: "A string"}` | `"A string"` |
| `""` | `[0: ""]` | `false` | `0` | `null` | `0.0` | `{$scalar: ""}` | `""` |
| `["A string"]` | `[0: "A string"]` | `true` | `1` | `null` | `1.0` | `{$0: "A string"}` | `array` |
| `[]` | `[]` | `false` | `0` | `null` | `0.0` | `{}` | `array ` |
| `true` | `[0: true]` | `true` | `1` | `null` | `1.0` | `{$scalar: true}` | `"1"` |
| `false` | `[0: false]` | `false` | `0` | `null` | `0.0` | `{$scalar: false}` | `""` |
| `123` | `[0: 123]` | `true` | `123` | `null` | `123.0` | `{$scalar: 123}` | `"123"` |
| `0` | `[0: 0]` | `false` | `0` | `null` | `0.0` | `{$scalar: 0}` | `"0"` |
| `null` | `[]` | `false` | `0` | `null` | `0.0` | `{}` | `""` |
| `45.67` | `[0: 45.67]` | `true` | `45` | `null` | `45.67` | `{$scalar: 45.67}` | `"45.67"` |
| `0.0` | `[0: 0.0]` | `false` | `0` | `null` | `0.` | `{$scalar: 0.0}` | `"0"` |
| `{$p: "A string"}` | `["p": "A string"]` | `true` | `1` | `null` | `1.0` | `{$p: "A string"}` | `"stdClass"` |
