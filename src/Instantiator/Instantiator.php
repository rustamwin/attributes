<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Instantiator;

use ReflectionAttribute;

/**
 * @internal
 */
final class Instantiator implements InstantiatorInterface
{
    /**
     * @psalm-template T of object
     * @psalm-param ReflectionAttribute<T> $attribute
     * @psalm-return T
     *
     * @param ReflectionAttribute $attribute
     *
     * @return object
     */
    public function instantiate(ReflectionAttribute $attribute): object
    {
        // TODO: check
        return $attribute->newInstance();
    }
}
