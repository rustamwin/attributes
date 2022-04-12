<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Support;

use ReflectionClass;
use RustamWin\Attributes\Handler\AttributeHandlerInterface;

final class SimpleHandler implements AttributeHandlerInterface
{
    private static array $values = [];

    /**
     * @inheritDoc
     */
    public function handle(ReflectionClass $class, iterable $attributes): void
    {
        foreach ($attributes as $resolved) {
            /** @var MockAttribute $attribute */
            $attribute = $resolved->getAttribute();
            self::$values[] = $attribute->value;
        }
    }

    public static function getValues(): array
    {
        return self::$values;
    }
}
