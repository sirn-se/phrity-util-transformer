<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Test class.
 */
class TestTranslatorClass implements TranslatorInterface
{
    /**
     * @param string       $id
     * @param array<mixed> $parameters
     * @param string|null  $domain
     * @param string|null  $locale
     */
    public function trans(
        string $id,
        array $parameters = [],
        string|null $domain = null,
        string|null $locale = null
    ): string {
        return 'trans()';
    }

    public function getLocale(): string
    {
        return 'sv_SE';
    }
}
