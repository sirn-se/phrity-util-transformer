[Documentation](../../README.md) / Symfony Normalizer

## Introduction

The `SymfonyNormalizerWrapper` can wrap any class implementing Symfony `NormalizerInterface`.

## Using the wrapper

Example of using some of Symfony´s normalizers.

```php
// The PropertyNormalizer, object -> array
$normalizer = new PropertyNormalizer();
$wrapper = new NormalizerWrapper($normalizer);
$wrapper->canTransform($object); // -> bool
$wrapper->transform($object); // -> array output

// The TranslatableNormalizer, TranslatableInterface -> string
$normalizer = new TranslatableNormalizer($translator);
$wrapper = new NormalizerWrapper($normalizer);
$wrapper->canTransform($translatable); // -> bool
$wrapper->transform($translatable); // -> string output

// The UidNormalizer, UID -> string
$normalizer = new UidNormalizer();
$wrapper = new NormalizerWrapper($normalizer);
$wrapper->canTransform($uuid); // -> bool
$wrapper->transform($uuid); // -> string output
```
