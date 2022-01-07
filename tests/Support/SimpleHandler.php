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
    public function handle(ReflectionClass $class, array $attributes): void
    {
        foreach ($attributes as $resolved) {
            if ($resolved->getReflectionTarget() instanceof \ReflectionMethod) {
                /** @var MockAttribute $attribute */
                $attribute = $resolved->getAttribute();
                self::$values[] = $resolved->getReflectionTarget()->invoke(
                    $class->newInstanceWithoutConstructor(),
                    $attribute->value,
                    $attribute->args
                );
            }
        }
    }

    public static function getValues(): array
    {
        return self::$values;
    }
}
