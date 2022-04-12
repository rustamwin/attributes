<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Instantiator;

/**
 * @psalm-suppress ImplementedParamTypeMismatch, InvalidScalarArgument
 */
final class Instantiator extends \Spiral\Attributes\Internal\Instantiator\Instantiator
{
    public function instantiate(\ReflectionClass $attr, array $arguments, \Reflector $context = null): object
    {
        return $attr->newInstanceArgs($arguments);
    }
}
