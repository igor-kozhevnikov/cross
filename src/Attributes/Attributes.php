<?php

declare(strict_types=1);

namespace Cross\Attributes;

use Cross\Attributes\Attribute\Argument\Argument;
use Cross\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Attributes\Attribute\AttributeInterface;
use Cross\Attributes\Attribute\Option\Option;
use Cross\Attributes\Attribute\Option\OptionInterface;

class Attributes implements AttributesInterface
{
    /**
     * Attributes.
     *
     * @var array<int, AttributeInterface>
     */
    private array $attributes;

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
     * Static constructor.
     *
     * @param array<int, AttributeInterface> $attributes
     */
    public static function make(array $attributes = []): self
    {
        return new self($attributes);
    }

    /**
     * @inheritDoc
     */
    public function merge(AttributesInterface $attributes): AttributesInterface
    {
        $this->attributes = array_merge($this->attributes, $attributes->all());
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set(array $attributes): self
    {
        $this->attributes = [];

        foreach ($attributes as $attribute) {
            $this->add($attribute);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(AttributeInterface $attribute): self
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function argument(string $name): ArgumentInterface
    {
        $argument = Argument::make($name)->container($this);
        $this->add($argument);
        return $argument;
    }

    /**
     * @inheritDoc
     */
    public function option(string $name): OptionInterface
    {
        $option = Option::make($name)->container($this);
        $this->add($option);
        return $option;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->attributes;
    }
}
