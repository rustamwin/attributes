<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Handler;

use ReflectionClass;
use RustamWin\Attributes\Dto\ResolvedAttribute;

interface AttributeHandlerInterface
{
    /**
     * @psalm-param iterable<ResolvedAttribute> $attributes
     */
    public function handle(ReflectionClass $class, iterable $attributes): void;
}
