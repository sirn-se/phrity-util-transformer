<?php

declare(strict_types=1);

namespace Phrity\Util\Transformer\Test;

use Nyholm\Psr7\MessageTrait;
use Psr\Http\Message\MessageInterface;

/**
 * Test class.
 */
class TestHttpMessage implements MessageInterface
{
    use MessageTrait;
}
