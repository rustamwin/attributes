<?php

declare(strict_types=1);

namespace RustamWin\Attributes\Reader;

use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use Reflector;
use RustamWin\Attributes\Dto\ResolvedAttribute;
use RustamWin\Attributes\Instantiator\Instantiator;
use RustamWin\Attributes\Instantiator\InstantiatorInterface;

final class AttributeReader implements AttributeReaderInterface
{
    private InstantiatorInterface $instantiator;

    #[Pure]
    public function __construct(?InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator ?? new Instantiator();
    }

    /**
     * @inheritDoc
     */
    public function read(ReflectionClass $ref): array
    {
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
        $constants = $class->getReflectionConstants();
        return $this->mapAttributes($constants);
    }

    private function readPropertyAttributes(ReflectionClass $class): array
    {
        $properties = $class->getProperties();
        return $this->mapAttributes($properties);
    }

    private function readMethodAttributes(ReflectionClass $class): array
    {
        $methods = $class->getMethods();
        $mappedMethods = $this->mapAttributes($methods);

        $mappedParameters = array_map(
            fn (ReflectionMethod $method) => $this->readParameterAttributes($method),
            $methods
        );

        return array_merge($mappedMethods, ...$mappedParameters);
    }

    private function readParameterAttributes(ReflectionMethod $method): array
    {
        $parameters = $method->getParameters();
        return $this->mapAttributes($parameters);
    }

    /**
     * @psalm-template T instance of Reflector
     *
     * @psalm-param T $ref
     * @param Reflector $ref
     *
     * @return ResolvedAttribute[]
     */
    private function readAttributes(Reflector $ref): array
    {
        return array_map(
            fn (ReflectionAttribute $attribute) => new ResolvedAttribute(
                attribute: $this->instantiator->instantiate($attribute),
                reflectionTarget: $ref
            ),
            $this->filterAttributes(...$ref->getAttributes())
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
     * @psalm-template T instance of Reflector
     *
     * @param Reflector[] $targets
     *
     * @psalm-param list<T> $targets
     *
     * @return array
     */
    private function mapAttributes(array $targets): array
    {
        $resolvedAttributes = array_map(
            fn (Reflector $targetRef) => $this->readAttributes($targetRef),
            $targets
        );

        return array_merge(...$resolvedAttributes);
    }
}
