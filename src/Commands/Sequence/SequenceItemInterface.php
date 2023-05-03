<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

interface SequenceItemInterface
{
    /**
     * Returns a name.
     */
    public function getName(): string;

    /**
     * Returns the parent sequence.
     *
     * @return SequenceInterface<SequenceItemInterface>
     */
    public function end(): SequenceInterface;
}
