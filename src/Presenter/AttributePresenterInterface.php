<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Presenter;

use RustamWin\Attributes\Dto\ResolvedAttribute;

interface AttributePresenterInterface
{
    /**
     * @param ResolvedAttribute[] $attributes
     */
    public function present(array $attributes): mixed;
}
