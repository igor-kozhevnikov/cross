<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\AttributeInterface;

interface AttributesInterface
{
    /**
     * Adds an attribute.
     */
    public function add(AttributeInterface $attribute): void;

    /**
     * Returns all attributes.
     *
     * @return array<string, AttributeInterface>
     */
    public function getAll(): array;
}
