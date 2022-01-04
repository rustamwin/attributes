<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Dto;

use Reflector;

final class ResolvedAttribute
{
    /**
     * @template T instance of Reflector
     *
     * @param object $attribute
     * @param T $reflectionTarget
     */
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

    /**
     * @psalm-template T of Reflector
     *
     * @psalm-return T
     *
     * @return Reflector
     */
    public function getReflectionTarget(): Reflector
    {
        return $this->reflectionTarget;
    }
}
