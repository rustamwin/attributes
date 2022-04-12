<?php

declare(strict_types=1);

namespace RustamWin\Attributes;

use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use RustamWin\Attributes\Dto\ResolvedAttribute;
use RustamWin\Attributes\Handler\AttributeHandlerInterface;
use RustamWin\Attributes\Instantiator\Instantiator;
use Spiral\Attributes\AttributeReader;
use Spiral\Attributes\ReaderInterface;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;

final class Attributes
{
    private ReaderInterface $attributeReader;
    private AttributeHandlerInterface $attributeHandler;
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
        ?ReaderInterface $attributeReader = null
    ) {
        $this->attributeHandler = $attributeHandler;
        $this->attributeReader = $attributeReader ?? new AttributeReader(new Instantiator());
    }

    /**
     * @throws ReflectionException
     */
    public function handle(): void
    {
        /** @var ReflectionClass[] $classes */
        $classes = array_unique(array_merge($this->getClasses(), $this->loadClasses()));
        foreach ($classes as $reflectionClass) {
            $resolvedAttributes = $this->resolveAttributes($reflectionClass);
            $this->attributeHandler->handle($reflectionClass, $resolvedAttributes);
        }
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

    private function resolveAttributes(ReflectionClass $ref): iterable
    {
        // class attributes
        foreach ($this->attributeReader->getClassMetadata($ref) as $attribute) {
            yield new ResolvedAttribute(attribute: $attribute, reflectionTarget: $ref);
        }
        // properties
        foreach ($ref->getProperties() as $property) {
            foreach ($this->attributeReader->getPropertyMetadata($property) as $attribute) {
                yield new ResolvedAttribute(attribute: $attribute, reflectionTarget: $property);
            }
        }
        // constants
        foreach ($ref->getConstants() as $constant) {
            foreach ($this->attributeReader->getConstantMetadata($constant) as $attribute) {
                yield new ResolvedAttribute(attribute: $attribute, reflectionTarget: $constant);
            }
        }
        // methods
        foreach ($ref->getMethods() as $method) {
            foreach ($this->attributeReader->getFunctionMetadata($method) as $attribute) {
                yield new ResolvedAttribute(attribute: $attribute, reflectionTarget: $method);
                // parameters
                foreach ($method->getParameters() as $parameter) {
                    foreach ($this->attributeReader->getParameterMetadata($parameter) as $parameterAttribute) {
                        yield new ResolvedAttribute(attribute: $parameterAttribute, reflectionTarget: $parameter);
                    }
                }
            }
        }
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
