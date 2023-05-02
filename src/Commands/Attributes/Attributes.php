<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use ArrayIterator;
use Cross\Commands\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Commands\Attributes\Attribute\AttributeFactory;
use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Cross\Commands\Attributes\Attribute\Option\OptionInterface;
use Fluent\FluentFactory;
use Fluent\FluentMaker;
use IteratorAggregate;
use Traversable;

/**
 * @method ArgumentInterface argument(string $name)
 * @method OptionInterface option(string $name)
 */
class Attributes implements AttributesInterface, IteratorAggregate
{
    use FluentMaker;
    use FluentFactory;

    /**
     * Attributes.
     *
     * @var array<int, AttributeInterface>
     */
    protected array $attributes;

    /**
     * Constructor.
     *
     * @param array<int, AttributeInterface> $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->set($attributes);
    }

    /**
     * Merges the attributes.
     */
    public function merge(AttributesInterface $attributes): void
    {
        $this->attributes = array_merge($this->attributes, $attributes->all());
    }

    /**
     * Defines the attributes.
     *
     * @param array<int, AttributeInterface> $attributes
     */
    public function set(array $attributes): void
    {
        $this->reset();

        foreach ($attributes as $attribute) {
            $this->add($attribute);
        }
    }

    /**
     * @inheritDoc
     */
    public function add(AttributeInterface $attribute): void
    {
        $this->attributes[$attribute->getName()] = $attribute;
    }

    /**
     * Returns an attribute by the given name.
     */
    public function get(string $name): ?AttributeInterface
    {
        return $this->attributes[$name];
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * Resets all attributes.
     */
    public function reset(): void
    {
        $this->attributes = [];
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * @inheritDoc
     */
    public function getFluentFactory(): object
    {
        return new AttributeFactory($this);
    }
}
