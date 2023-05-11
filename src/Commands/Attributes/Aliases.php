<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Aliases
{
    public readonly array $value;

    /**
     * Constructor.
     */
    public function __construct(string ...$value)
    {
        $this->value = $value;
    }
}
