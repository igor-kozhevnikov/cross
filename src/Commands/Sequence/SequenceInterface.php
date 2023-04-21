<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

interface SequenceInterface
{
    /**
     * Defines the sequence.
     *
     * @param array<int, ItemInterface> $items
     */
    public function set(array $items): self;

    /**
     * Adds an item.
     */
    public function add(ItemInterface $item): self;

    /**
     * Make an item.
     */
    public function item(string $name): ItemInterface;

    /**
     * Returns all items.
     *
     * @return array<int, ItemInterface>
     */
    public function all(): array;
}
