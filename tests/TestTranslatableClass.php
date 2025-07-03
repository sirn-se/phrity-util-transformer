<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use Symfony\Contracts\Translation\{
    TranslatableInterface,
    TranslatorInterface,
};

/**
 * Test class.
 */
class TestTranslatableClass implements TranslatableInterface
{
    public function trans(TranslatorInterface $translator, string|null $locale = null): string
    {
        return 'ok';
    }
}
