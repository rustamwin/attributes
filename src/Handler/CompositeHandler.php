<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Handler;

use ReflectionClass;

final class CompositeHandler implements AttributeHandlerInterface
{
    /**
     * @param AttributeHandlerInterface[] $handlers
     */
    public function __construct(private array $handlers)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(ReflectionClass $class, array $attributes): void
    {
        $this->validateHandlers();
        foreach ($this->handlers as $handler) {
            $handler->handle($class, $attributes);
        }
    }

    private function validateHandlers(): void
    {
        foreach ($this->handlers as $handler) {
            if (!$handler instanceof AttributeHandlerInterface) {
                throw new \InvalidArgumentException(sprintf('Handler must implement AttributeHandlerInterface, got %s.', get_debug_type($handler)));
            }
        }
    }
}
