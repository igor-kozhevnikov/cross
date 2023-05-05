<?php

declare(strict_types=1);

namespace Cross\Sequence;

use Cross\Sequence\Item\ItemInterface;

interface SequenceInterface
{
    /**
     * Adds an item.
     */
    public function add(ItemInterface $item): void;

    /**
     * Returns all commands.
     *
     * @return array<string, ItemInterface>
     */
    public function getAll(): array;
}
