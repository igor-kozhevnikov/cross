<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Cross\Commands\Attributes\Attribute\Option\OptionInterface;

interface AttributesInterface
{
    /**
     * Merge the attributes.
     */
    public function merge(AttributesInterface $attributes): self;

    /**
     * Define the attributes.
     *
     * @param array<int, AttributeInterface> $attributes
     */
    public function set(array $attributes): self;

    /**
     * Add a attribute.
     */
    public function add(AttributeInterface $attribute): self;

    /**
     * Add an argument by the builder.
     */
    public function argument(string $name): ArgumentInterface;

    /**
     * Add an option by the builder.
     */
    public function option(string $name): OptionInterface;

    /**
     * Returns all attributes
     *
     * @return array<int, AttributeInterface>
     */
    public function all(): array;
}
