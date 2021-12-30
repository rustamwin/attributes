<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Instantiator;

use ReflectionAttribute;

interface InstantiatorInterface
{
    /**
     * @psalm-template T of object
     *
     * @psalm-param ReflectionAttribute<T> $attribute
     *
     * @psalm-return T
     */
    public function instantiate(ReflectionAttribute $attribute): object;
}
