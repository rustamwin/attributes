<?php

namespace RustamWin\Attributes\Tests\Dto;

use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Dto\ResolvedAttribute;
use RustamWin\Attributes\Tests\Support\Entity\MockEntity;
use RustamWin\Attributes\Tests\Support\MockAttribute;

final class ResolvedAttributeTest extends TestCase
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
