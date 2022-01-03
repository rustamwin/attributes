<?php

namespace RustamWin\Attributes\Tests\Instantiator;

use RustamWin\Attributes\Instantiator\Instantiator;
use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Tests\Support\MockAttribute;
use RustamWin\Attributes\Tests\Support\MockEntity;

final class InstantiatorTest extends TestCase
{
    public function testInstantiate(): void
    {
        $instantiator = new Instantiator();
        $class = new \ReflectionMethod(MockEntity::class, 'getValue');

        $this->assertCount(1, $class->getAttributes());
        $this->assertInstanceOf(MockAttribute::class, $instantiator->instantiate($class->getAttributes()[0]));
    }
}
