<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use JsonSerializable;

/**
 * JsonSerializable test class.
 */
class TestJsonSerializableObject implements JsonSerializable
{
    private mixed $return;

    public function __construct(mixed $return)
    {
        $this->return = $return;
    }

    public function jsonSerialize(): mixed
    {
        return $this->return;
    }
}
