<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

interface ItemInterface
{
    /**
     * Returns the parent sequence.
     */
    public function end(): SequenceInterface;
}
