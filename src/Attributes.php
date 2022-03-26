<?php

declare(strict_types=1);

namespace RustamWin\Attributes;

use JetBrains\PhpStorm\Pure;
use Psr\SimpleCache\CacheInterface;
use ReflectionClass;
use ReflectionException;
use RustamWin\Attributes\Dto\ResolvedAttribute;
use RustamWin\Attributes\Handler\AttributeHandlerInterface;
use RustamWin\Attributes\Reader\AttributeReader;
use RustamWin\Attributes\Reader\AttributeReaderInterface;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;

final class Attributes
{
    private AttributeReaderInterface $attributeReader;
    private AttributeHandlerInterface $attributeHandler;
    private ?CacheInterface $cache;
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
        AttributeHandlerInterface $attributeHandler,
        ?AttributeReaderInterface $attributeReader = null,
        ?CacheInterface $cache = null
    ) {
        $this->attributeHandler = $attributeHandler;
        $this->attributeReader = $attributeReader ?? new AttributeReader(new Instantiator\Instantiator());
        $this->cache = $cache;
    }

    /**
     * @throws ReflectionException
     */
    public function handle(): void
    {
        /** @var ReflectionClass[] $classes */
        $classes = array_unique(array_merge($this->getClasses(), $this->loadClasses()));
        foreach ($classes as $reflectionClass) {
            $resolvedAttributes = $this->attributeReader->read($reflectionClass);
            $this->cache?->set($reflectionClass->getName(), $resolvedAttributes);
            $this->attributeHandler->handle($reflectionClass, $resolvedAttributes);
        }
    }

    /**
     * @param class-string $class
     *
     * @throws ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function getClassMetadata(string $class): array
    {
        /** @var ResolvedAttribute[]|null $resolvedAttributes */
        $resolvedAttributes = $this->cache?->get($class);
        if ($resolvedAttributes !== null) {
            return $resolvedAttributes;
        }
        $ref = new ReflectionClass($class);
        $resolvedAttributes = $this->attributeReader->read($ref);
        $this->cache?->set($class, $resolvedAttributes);

        return $resolvedAttributes;
    }

    /**
     * @psalm-param array<class-string> $classes
     *
     * @return $this
     */
    public function setClasses(array $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @psalm-param array<array-key, string> $directories
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
     * @psalm-return array<array-key, ReflectionClass<object>>
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
