<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use PHPUnit\Framework\TestCase;
use Phrity\Util\Transformer\{
    TransformerException,
    Type,
};
use Phrity\Util\Transformer\Symfony\NormalizerWrapper;
use Symfony\Component\Serializer\Normalizer\{
    PropertyNormalizer,
    TranslatableNormalizer,
    UidNormalizer,
};
use Symfony\Component\Uid\Uuid;

/**
 * Transformer test class.
 */
class SymfonyNormalizerWrapperTest extends TestCase
{
    public function testSymfonyUidNormalizer(): void
    {
        $transformer = new NormalizerWrapper(new UidNormalizer());
        $this->assertTrue($transformer->canTransform(Uuid::v4()));
        $this->assertTrue($transformer->canTransform(Uuid::v4(), Type::STRING));
        $this->assertFalse($transformer->canTransform('Nope'));
        $this->assertFalse($transformer->canTransform(Uuid::v4(), Type::OBJECT));
        $this->assertEquals(
            '6ba7b812-9dad-11d1-80b4-00c04fd430c8',
            $transformer->transform(Uuid::fromString(Uuid::NAMESPACE_OID))
        );
    }

    public function testSymfonyTranslatableNormalizer(): void
    {
        $translator = new TestTranslatorClass();
        $translatable = new TestTranslatableClass();
        $transformer = new NormalizerWrapper(new TranslatableNormalizer($translator));
        $this->assertTrue($transformer->canTransform($translatable));
        $this->assertTrue($transformer->canTransform($translatable, Type::STRING));
        $this->assertFalse($transformer->canTransform('Nope'));
        $this->assertFalse($transformer->canTransform($translatable, Type::OBJECT));
        $this->assertEquals('ok', $transformer->transform($translatable));
    }

    public function testSymfonyPropertyNormalizer(): void
    {
        $object = new TestObject();
        $transformer = new NormalizerWrapper(new PropertyNormalizer());
        $this->assertTrue($transformer->canTransform($object));
        $this->assertTrue($transformer->canTransform($object, Type::ARRAY));
        $this->assertFalse($transformer->canTransform('Nope'));
        $this->assertFalse($transformer->canTransform($object, Type::OBJECT));
        $this->assertEquals([
            'public' => 'public',
            'protected' => 'protected',
            'private' => 'private',
        ], $transformer->transform($object));
    }

    public function testException(): void
    {
        $transformer = new NormalizerWrapper(new UidNormalizer());
        $this->expectException(TransformerException::class);
        $this->expectExceptionMessage(
            "Normalizer Symfony\Component\Serializer\Normalizer\UidNormalizer to not support 'string'."
        );
        $transformer->transform('no');
    }
}
