<?php

namespace RustamWin\Attributes\Tests\Dto;

use RustamWin\Attributes\Dto\ResolvedAttribute;
use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Tests\Support\MockAttribute;
use RustamWin\Attributes\Tests\Support\MockEntity;

class ResolvedAttributeTest extends TestCase
{
    public function testGetters(): void
    {
        $att = new MockAttribute('Test');
        $ref = new \ReflectionClass(MockEntity::class);
        $resolvedAttribute = new ResolvedAttribute($att, $ref);

        $this->assertSame($att, $resolvedAttribute->getAttribute());
        $this->assertSame($ref, $resolvedAttribute->getReflectionTarget());
    }
}
