<?php

namespace RustamWin\Attributes\Tests\Presenter;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RustamWin\Attributes\Presenter\AttributePresenterInterface;
use RustamWin\Attributes\Presenter\CompositePresenter;
use RustamWin\Attributes\Tests\Support\MockEntity;

class CompositePresenterTest extends TestCase
{

    public function testPresent(): void
    {
        $p = $this->getPresenter();
        $presenter = new CompositePresenter([$p]);

        $result = $presenter->present(new ReflectionClass(MockEntity::class), []);

        self::assertInstanceOf(\Traversable::class, $result);
        self::assertContainsOnlyInstancesOf(ReflectionClass::class, iterator_to_array($result));
    }

    private function getPresenter(): AttributePresenterInterface
    {
        return new class () implements AttributePresenterInterface {

            public function present(ReflectionClass $class, array $attributes): mixed
            {
                return $class;
            }
        };
    }
}
