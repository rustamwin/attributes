<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Support;

use Attribute;
use JetBrains\PhpStorm\Immutable;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class MockAttribute
{
    public function __construct(public string $value, public array $args = [])
    {
    }
}
