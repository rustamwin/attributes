<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests;

use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Attributes;
use RustamWin\Attributes\Presenter\CompositePresenter;
use RustamWin\Attributes\Tests\Support\MockEntity;
use RustamWin\Attributes\Tests\Support\SimplePresenter;

final class AttributesTest extends TestCase
{
    public function testHandle(): void
    {
        $this->assertContains('Hello, World!', SimplePresenter::getValues());
    }

    public function testWithCompositePresenter(): void
    {
        $attributes = new Attributes(attributePresenter: new CompositePresenter([new SimplePresenter()]));

        $attributes->setClasses([MockEntity::class])->setDirectories([__DIR__ . '/Support'])->handle();

        $this->assertContains('Hello, World!', SimplePresenter::getValues());

    }
}
