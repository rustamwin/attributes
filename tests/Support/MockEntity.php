<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Support;

final class MockEntity
{
    #[MockAttribute('Hello, %s!', args: ['World'])]
    public function getValue(string $format, array $values): string
    {
        return sprintf($format, ...$values);
    }
}
