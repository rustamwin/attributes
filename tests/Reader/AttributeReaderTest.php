<?php

namespace RustamWin\Attributes\Tests\Reader;

use RustamWin\Attributes\Dto\ResolvedAttribute;
use RustamWin\Attributes\Reader\AttributeReader;
use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Tests\Support\MockEntity;

class AttributeReaderTest extends TestCase
{
    public function testRead(): void
    {
        $ref = new \ReflectionClass(MockEntity::class);
        $reader = new AttributeReader();

        $resolvedAttrs = $reader->read($ref);

        $this->assertContainsOnlyInstancesOf(ResolvedAttribute::class, $resolvedAttrs);
    }
}
