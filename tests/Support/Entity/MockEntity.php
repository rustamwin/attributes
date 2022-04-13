<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Support\Entity;

use RustamWin\Attributes\Tests\Support\MockAttribute;

#[MockAttribute(value: 'class')]
final class MockEntity
{
    #[MockAttribute(value: 'const')]
    private const TYPE = 'class';

    #[MockAttribute(value: 'property')]
    private int $id;

    #[MockAttribute(value: 'method')]
    public function getValue(#[MockAttribute('parameter')] string $format, array $values): string
    {
        return sprintf($format, ...$values);
    }
}
