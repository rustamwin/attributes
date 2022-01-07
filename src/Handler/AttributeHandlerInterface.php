<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Handler;

use ReflectionClass;
use RustamWin\Attributes\Dto\ResolvedAttribute;

interface AttributeHandlerInterface
{
    /**
     * @param ReflectionClass $class
     * @param ResolvedAttribute[] $attributes
     */
    public function handle(ReflectionClass $class, array $attributes): void;
}
