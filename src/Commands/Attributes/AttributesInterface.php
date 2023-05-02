<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\AttributeInterface;
use Traversable;

interface AttributesInterface extends Traversable
{
    /**
     * Adds an attribute.
     */
    public function add(AttributeInterface $attribute): void;

    /**
     * Returns all attributes.
     *
     * @return array<array-key, AttributeInterface>
     */
    public function all(): array;
}
