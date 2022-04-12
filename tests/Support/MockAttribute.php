<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Support;

use Attribute;

#[Attribute(Attribute::TARGET_ALL | Attribute::IS_REPEATABLE)]
final class MockAttribute
{
    public function __construct(public string $value)
    {
    }
}
