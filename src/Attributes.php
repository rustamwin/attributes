<?php

declare(strict_types=1);

namespace RustamWin\Attributes;

use ReflectionClass;
use RustamWin\Attributes\Presenter\AttributePresenterInterface;
use RustamWin\Attributes\Reader\AttributeReaderInterface;
use Spiral\Tokenizer\ClassLocator;
use SplObjectStorage;
use Symfony\Component\Finder\Finder;

final class Attributes
{
    private AttributeReaderInterface $attributeReader;
    private SplObjectStorage $attributes;
    private AttributePresenterInterface $attributePresenter;
    private array $directories = [];
    /**
     * @var array<class-string>
     */
    private array $classes = [];

    public function __construct(
        AttributeReaderInterface $attributeReader,
        AttributePresenterInterface $attributePresenter
    ) {
        $this->attributeReader = $attributeReader;
        $this->attributePresenter = $attributePresenter;
        $this->attributes = new SplObjectStorage();
    }

    public function handle(): void
    {
        /** @var ReflectionClass[] $classes */
        $classes = array_unique(array_merge($this->getClasses(), $this->loadClasses()));
        foreach ($classes as $reflectionClass) {
            $resolvedAttributes = $this->attributeReader->read($reflectionClass);
            $this->attributes->attach($reflectionClass, $resolvedAttributes);
        }
    }

    /**
     * @return ReflectionClass[]
     * @throws \ReflectionException
     */
    private function getClasses(): array
    {
        return array_map(
            static fn (string $className) => new ReflectionClass($className),
            $this->classes
        );
    }

    /**
     * @return ReflectionClass[]
     */
    private function loadClasses(): array
    {
        $finder = Finder::create()->name('*.php')->in($this->directories);
        $classes = (new ClassLocator($finder))->getClasses();

        return array_values($classes);
    }
}
