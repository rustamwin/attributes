<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Presenter;

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
    public function present(ReflectionClass $class, array $attributes): iterable
    {
        $this->validatePresenters();
        foreach ($this->presenters as $presenter) {
            yield $presenter->present($class, $attributes);
        }
    }

    private function validatePresenters(): void
    {
        foreach ($this->presenters as $presenter) {
            if (!$presenter instanceof AttributePresenterInterface) {
                throw new \InvalidArgumentException(sprintf('Presenter must implement AttributePresenterInterface, got %s.', get_debug_type($presenter)));
            }
        }
    }
}
