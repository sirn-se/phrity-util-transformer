[Documentation](../../README.md) / Throwable Converter

## Introduction

The `ThrowableConverter` converts a Throwable Object to Array, Object or String.

## Using the converter

```php
$converter = new ThrowableConverter();

// Convert defining type
$converter->canTransform($exception, Type::STRING); // -> bool
$converter->transform($exception, Type::STRING); // -> string output

// Force type conversion
$converter = new ThrowableConverter(Type::OBJECT);
$converter->canTransform($exception); // -> bool
$converter->transform($exception); // -> object output

// Define fields to use on object and array type (see available fields below)
$converter = new ThrowableConverter(Type::OBJECT, ['type', 'message', 'code']);
$converter->transform($exception); // -> object output
```


## Type conversion examples

If type is not specified, the converter return an Object.


| Input | Type: Array | Type: Object | Type: String |
|-|-|-|-|
| `$exception` | `[type: "RuntimeException", …]` |  `{$type: "RuntimeException", …}` | `"My error"` |

## Fields when type is Array or Object

```
type: Exception class
message: Error message
code: Error code
file: File name where thrown
line: File line number where thrown
trace: Backtrace
previous: Previous Throwable or null
```