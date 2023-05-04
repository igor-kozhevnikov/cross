<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

use Cross\Commands\Sequence\Item\SequenceItemInterface;

interface SequenceInterface
{
    /**
     * Adds an item.
     */
    public function add(SequenceItemInterface $item): void;

    /**
     * Returns all items.
     *
     * @return array<string, SequenceItemInterface>
     */
    public function getAll(): array;
}
