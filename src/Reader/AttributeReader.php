<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Reader;

use JetBrains\PhpStorm\Pure;
use Mbunge\PhpAttributes\Resolver\AttributeDto;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Reflector;
use RustamWin\Attributes\Dto\Attribute;
use RustamWin\Attributes\Dto\ResolvedAttribute;
use RustamWin\Attributes\Instantiator\Instantiator;
use RustamWin\Attributes\Instantiator\InstantiatorInterface;

final class AttributeReader implements AttributeReaderInterface
{
    #[Pure]
    public function __construct(private ?InstantiatorInterface $instantiator)
    {
        $this->instantiator ??= new Instantiator();
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function read(string $className): array
    {
        $ref = new ReflectionClass($className);

        return array_merge(
            $this->readClassAttributes($ref),
            $this->readConstantAttributes($ref),
            $this->readPropertyAttributes($ref),
            $this->readMethodAttributes($ref)
        );
    }

    private function readClassAttributes(ReflectionClass $class): array
    {
        return $this->readAttributes($class);
    }

    private function readConstantAttributes(ReflectionClass $class): array
    {
        $target = $class->getReflectionConstants();
        return $this->flatMap($target);
    }

    private function readPropertyAttributes(ReflectionClass $class): array
    {
        $target = $class->getProperties();
        return $this->flatMap($target);
    }

    private function readMethodAttributes(ReflectionClass $class): array
    {
        $target = $class->getMethods();
        $mappedMethods = $this->flatMap($target);

        $mappedParameters = array_map(
            fn ($method) => $this->readParameterAttributes($method),
            $target
        );

        return array_merge($mappedMethods, ...$mappedParameters);
    }

    private function readParameterAttributes(ReflectionMethod $method): array
    {
        $target = $method->getParameters();
        return $this->flatMap($target);
    }

    /**
     * @param Reflector $class
     * @return Attribute[]
     */
    private function readAttributes(Reflector $class): array
    {
        return array_map(
            static fn (ReflectionAttribute $attribute) => new ResolvedAttribute(
                attribute: $this->instantiator->instantiate($attribute),
                reflectionTarget: $class
            ),
            $this->filterAttributes($class->getAttributes())
        );
    }

    private function filterAttributes(ReflectionAttribute ...$attributes): array
    {
        return array_filter(
            $attributes,
            static fn (ReflectionAttribute $attribute) => class_exists($attribute->getName())
        );
    }

    /**
     * @param array $target
     * @return array
     */
    private function flatMap(array $target): array
    {
        $mappedRef = array_map(
            fn ($specificRef) => $this->readAttributes($specificRef),
            $target
        );

        return array_merge(...$mappedRef);
    }
}
