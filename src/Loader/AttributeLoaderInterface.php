<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Loader;

interface AttributeLoaderInterface
{
    /**
     * @return array<class-string|callable-string>
     */
    public function load(): array;
}
