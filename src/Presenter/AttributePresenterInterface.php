<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Presenter;

use ReflectionClass;
use RustamWin\Attributes\Dto\ResolvedAttribute;

interface AttributePresenterInterface
{
    /**
     * @param ReflectionClass $class
     * @param ResolvedAttribute[] $attributes
     */
    public function present(ReflectionClass $class, array $attributes): mixed;
}
