<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Dto;

use Reflector;

final class ResolvedAttribute
{
    /**
     * @template T of Reflector
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
     * @template T of Reflector
     *
     * @return T
     */
    public function getReflectionTarget(): Reflector
    {
        return $this->reflectionTarget;
    }
}
