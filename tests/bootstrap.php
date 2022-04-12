<?php

declare(strict_types=1);

use RustamWin\Attributes\Attributes;
use RustamWin\Attributes\Tests\Support\Entity\MockEntity;
use RustamWin\Attributes\Tests\Support\SimpleHandler;

require dirname(__DIR__) . '/vendor/autoload.php';

$attributes = new Attributes(attributeHandler: new SimpleHandler());

$attributes->setClasses([MockEntity::class])->handle();
