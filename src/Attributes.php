<?php

declare(strict_types=1);

namespace RustamWin\Attributes;

use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use RustamWin\Attributes\Presenter\AttributePresenterInterface;
use RustamWin\Attributes\Reader\AttributeReader;
use RustamWin\Attributes\Reader\AttributeReaderInterface;
use Spiral\Tokenizer\ClassLocator;
use SplObjectStorage;
use Symfony\Component\Finder\Finder;

final class Attributes
{
    private AttributeReaderInterface $attributeReader;
    private SplObjectStorage $attributes;
    private AttributePresenterInterface $attributePresenter;
    /**
     * @var array<array-key, string>
     */
    private array $directories = [];
    /**
     * @var array<class-string>
     */
    private array $classes = [];

    #[Pure]
    public function __construct(
        AttributePresenterInterface $attributePresenter,
        ?AttributeReaderInterface $attributeReader = null,
    ) {
        $this->attributeReader = $attributeReader ?? new AttributeReader(new Instantiator\Instantiator());
        $this->attributePresenter = $attributePresenter;
        $this->attributes = new SplObjectStorage();
    }

    /**
     * @throws ReflectionException
     */
    public function handle(): void
    {
        $classes = array_unique(array_merge($this->getClasses(), $this->loadClasses()));
        foreach ($classes as $reflectionClass) {
            $resolvedAttributes = $this->attributeReader->read($reflectionClass);
            $this->attributes->attach($reflectionClass);
            $this->attributePresenter->present($reflectionClass, $resolvedAttributes);
        }
    }

    /**
     * @param array<class-string> $classes
     *
     * @return $this
     */
    public function setClasses(array $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @param array<array-key, string> $directories
     *
     * @return $this
     */
    public function setDirectories(array $directories): self
    {
        $this->directories = $directories;

        return $this;
    }

    /**
     * @throws ReflectionException
     *
     * @return array<array-key, ReflectionClass<object>>
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
     *
     * @psalm-return list<ReflectionClass<object>>
     */
    private function loadClasses(): array
    {
        if ($this->directories === []) {
            return [];
        }
        $finder = Finder::create()->name('*.php')->in($this->directories);
        $classes = (new ClassLocator($finder))->getClasses();

        return array_values($classes);
    }
}
