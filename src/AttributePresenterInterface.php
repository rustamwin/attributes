<?php

declare(strict_types=1);

namespace RustamWin\Attributes;

interface AttributePresenterInterface
{
    /**
     * @param ResolvedAttribute[] $attributes
     * @return mixed
     */
    public function present(array $attributes): mixed;
}
