<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Reader;

use ReflectionClass;
use RustamWin\Attributes\Dto\ResolvedAttribute;

interface AttributeReaderInterface
{
    /**
     * @param ReflectionClass $ref
     * @return ResolvedAttribute[]
     */
    public function read(ReflectionClass $ref): array;
}
