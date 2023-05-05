<?php

declare(strict_types=1);

namespace Cross\Sequence;

interface SequenceKeeper
{
    /**
     * Returns a sequence.
     */
    public function getSequence(): SequenceInterface;
}
