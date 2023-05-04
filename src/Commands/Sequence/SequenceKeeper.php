<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

interface SequenceKeeper
{
    /**
     * Returns a sequence.
     */
    public function getSequence(): SequenceInterface;
}
