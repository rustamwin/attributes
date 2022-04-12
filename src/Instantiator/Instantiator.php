<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Instantiator;

final class Instantiator extends \Spiral\Attributes\Internal\Instantiator\Instantiator
{

    /**
     * @inheritDoc
     */
    public function instantiate(\ReflectionClass $attr, array $arguments, \Reflector $context = null): object
    {
        return $attr->newInstanceArgs($arguments);
    }
}
