<?php

declare(strict_types=1);

namespace RustamWin\Attributes;

use RustamWin\Attributes\Presenter\AttributePresenterInterface;
use RustamWin\Attributes\Reader\AttributeReaderInterface;
use SplObjectStorage;

final class Attributes
{
    private AttributeReaderInterface $attributeReader;
    private SplObjectStorage $attributes;
    private AttributePresenterInterface $attributePresenter;

    public function __construct(AttributeReaderInterface $attributeReader, AttributePresenterInterface $attributePresenter)
    {
        $this->attributeReader = $attributeReader;
        $this->attributePresenter = $attributePresenter;
        $this->attributes = new SplObjectStorage();
    }

    public function handle()
    {

    }

    private function loadAttributes()
    {

    }
}
