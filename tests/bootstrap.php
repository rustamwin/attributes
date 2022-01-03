<?php

declare(strict_types=1);

use RustamWin\Attributes\Attributes;
use RustamWin\Attributes\Tests\Support\MockEntity;
use RustamWin\Attributes\Tests\Support\SimplePresenter;

require dirname(__DIR__) . '/vendor/autoload.php';

$attributes = new Attributes(attributePresenter: new SimplePresenter());

$attributes->setClasses([MockEntity::class])->handle();
