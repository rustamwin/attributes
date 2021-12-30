<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Dto;

use Reflector;

final class ResolvedAttribute
{
    public function __construct(
        private object $attribute,
        private Reflector $reflectionTarget
    ) {
    }

    // Getters
    public function getAttribute(): object
    {
        return $this->attribute;
    }

    public function getReflectionTarget(): Reflector
    {
        return $this->reflectionTarget;
    }
}
