<?php

namespace RustamWin\Attributes\Tests\Instantiator;

use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Instantiator\Instantiator;
use RustamWin\Attributes\Tests\Support\Entity\MockEntity;
use RustamWin\Attributes\Tests\Support\MockAttribute;

final class InstantiatorTest extends TestCase
{
    public function testInstantiate(): void
    {
        $instantiator = new Instantiator();
        $method = new \ReflectionMethod(MockEntity::class, 'getValue');

        $this->assertCount(1, $method->getAttributes());
        $this->assertInstanceOf(MockAttribute::class, $instantiator->instantiate(new \ReflectionClass($method->getAttributes()[0]->getName()), $method->getParameters()));
    }
}
