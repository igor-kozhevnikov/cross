<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence\Item;

interface SequenceItemInterface
{
    /**
     * Returns a name.
     */
    public function getName(): string;
}
