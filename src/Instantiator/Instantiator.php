<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Instantiator;

/**
 * @internal
 */
final class Instantiator implements InstantiatorInterface
{
    public function instantiate(\ReflectionAttribute $attribute): object
    {
        // TODO
        return $attribute->newInstance();
    }
}
