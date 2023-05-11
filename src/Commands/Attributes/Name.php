<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Name
{
    /**
     * Constructor.
     */
    public function __construct(public readonly string $value)
    {
        //
    }
}
