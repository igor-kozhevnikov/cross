<?php

declare(strict_types=1);

namespace Cross\Commands\Attributes;

interface HasAttributes
{
    /**
     * Returns a stack of attributes.
     */
    public function getAttributes(): AttributesInterface;
}
