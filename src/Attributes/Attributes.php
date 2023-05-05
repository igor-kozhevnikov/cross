<?php

declare(strict_types=1);

namespace Cross\Attributes;

use Cross\Attributes\Attribute\AttributeFactory;
use Cross\Attributes\Attribute\AttributeInterface;

class Attributes implements AttributesInterface
{
    use AttributeFactory;

    /**
     * Attributes.
     *
     * @var array<string, AttributeInterface>
     */
    protected array $attributes;

    /**
     * Constructor.
     *
     * @param array<string, AttributeInterface> $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->set($attributes);
    }

    /**
     * Makes an instance.
     */
    public static function make(): self
    {
        return new self();
    }

    /**
     * Defines the attributes.
     *
     * @param array<string, AttributeInterface> $attributes
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
    public function getAll(): array
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
    public function getAttributes(): AttributesInterface
    {
        return $this;
    }
}
