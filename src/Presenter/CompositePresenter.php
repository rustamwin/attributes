<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Presenter;

use Generator;

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
    public function present(array $attributes): Generator
    {
        foreach ($this->presenters as $presenter) {
            yield $presenter->present($attributes);
        }
    }
}
