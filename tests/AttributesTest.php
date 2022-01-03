<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Tests;

use PHPUnit\Framework\TestCase;
use RustamWin\Attributes\Tests\Support\SimplePresenter;

class AttributesTest extends TestCase
{
    public function testHandle()
    {
        $this->assertContains('Hello, World!', SimplePresenter::getValues());
    }
}
