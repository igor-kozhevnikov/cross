<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Cross\Commands\Attributes\Attribute\Option\OptionInterface;

interface AttributesInterface
{
    /**
     * Merges the attributes.
     */
    public function merge(AttributesInterface $attributes): self;

    /**
     * Defines the attributes.
     *
     * @param array<int, AttributeInterface> $attributes
     */
    public function set(array $attributes): self;

    /**
     * Adds an attribute.
     */
    public function add(AttributeInterface $attribute): self;

    /**
     * Adds an argument.
     */
    public function argument(string $name): ArgumentInterface;

    /**
     * Adds an option.
     */
    public function option(string $name): OptionInterface;

    /**
     * Returns all attributes
     *
     * @return array<int, AttributeInterface>
     */
    public function all(): array;
}
