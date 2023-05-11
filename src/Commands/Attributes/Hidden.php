<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Hidden
{
    /**
     * Constructor.
     */
    public function __construct(public readonly bool $value = true)
    {
        //
    }
}
