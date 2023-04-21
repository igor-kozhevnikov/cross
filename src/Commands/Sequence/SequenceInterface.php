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
    public function set(array $items): void;

    /**
     * Adds an item.
     */
    public function add(ItemInterface $item): void;

    /**
     * Returns an item by a name.
     */
    public function get(string $name): ?ItemInterface;

    /**
     * Returns all items.
     *
     * @return array<int, ItemInterface>
     */
    public function all(): array;
}
