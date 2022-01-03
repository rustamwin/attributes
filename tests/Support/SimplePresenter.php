<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Support;

use ReflectionClass;
use RustamWin\Attributes\Presenter\AttributePresenterInterface;

final class SimplePresenter implements AttributePresenterInterface
{
    private static array $values = [];

    /**
     * @inheritDoc
     */
    public function present(ReflectionClass $class, array $attributes): mixed
    {
        foreach ($attributes as $resolved) {
            /** @var MockAttribute $attribute */
            $attribute = $resolved->getAttribute();
            self::$values[] = $resolved->getReflectionTarget()->invoke($class->newInstanceWithoutConstructor(), $attribute->value, $attribute->args);
        }
        return $attributes;
    }

    public static function getValues(): array
    {
        return self::$values;
    }
}
