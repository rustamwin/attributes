<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Presenter;

use Generator;
use ReflectionClass;

final class CompositePresenter implements AttributePresenterInterface
{
    /**
     * @param AttributePresenterInterface[] $presenters
     */
    public function __construct(private array $presenters)
    {
    }

    /**
     * @inheritDoc
     */
    public function present(ReflectionClass $class, array $attributes): Generator
    {
        foreach ($this->presenters as $presenter) {
            yield $presenter->present($class, $attributes);
        }
    }
}
