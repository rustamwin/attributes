<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests;

use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Attributes;
use RustamWin\Attributes\Handler\CompositeHandler;
use RustamWin\Attributes\Tests\Support\MockEntity;
use RustamWin\Attributes\Tests\Support\SimpleHandler;

final class AttributesTest extends TestCase
{
    public function testHandle(): void
    {
        $this->assertContains('Hello, World!', SimpleHandler::getValues());
    }

    public function testWithCompositePresenter(): void
    {
        $attributes = new Attributes(attributeHandler: new CompositeHandler([new SimpleHandler()]));

        $attributes->setClasses([MockEntity::class])->setDirectories([__DIR__ . '/Support'])->handle();

        $this->assertContains('Hello, World!', SimpleHandler::getValues());

    }
}
