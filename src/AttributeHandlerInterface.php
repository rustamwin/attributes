<?php

namespace RustamWin\Attributes;

interface AttributeHandlerInterface
{
    public function handle(string $className): mixed;
}
