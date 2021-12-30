<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Reader;

use RustamWin\Attributes\Dto\ResolvedAttribute;

interface AttributeReaderInterface
{
    /**
     * @param class-string $className
     * @return ResolvedAttribute[]
     */
    public function read(string $className): array;
}
