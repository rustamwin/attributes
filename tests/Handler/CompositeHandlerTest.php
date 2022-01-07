<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests\Handler;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RustamWin\Attributes\Handler\AttributeHandlerInterface;
use RustamWin\Attributes\Handler\CompositeHandler;
use RustamWin\Attributes\Tests\Support\MockEntity;

class CompositeHandlerTest extends TestCase
{

    public function testPresent(): void
    {
        $p = $this->getHandler();
        $handler = new CompositeHandler([$p]);

        $handler->handle(new ReflectionClass(MockEntity::class), []);

        self::assertCount(1, $p->getClasses());
        self::assertContainsOnlyInstancesOf(ReflectionClass::class, $p->getClasses());
    }

    private function getHandler(): AttributeHandlerInterface
    {
        return new class () implements AttributeHandlerInterface {
            private array $classes = [];

            public function handle(ReflectionClass $class, array $attributes): void
            {
                $this->classes[] = $class;
            }

            public function getClasses(): array
            {
                return $this->classes;
            }
        };
    }
}
