<?php

declare(strict_types=1);

namespace Cross\Attributes;

interface AttributesKeeper
{
    /**
     * Returns a stack of attributes.
     */
    public function getAttributes(): AttributesInterface;
}
