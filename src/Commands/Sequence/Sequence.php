<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Sequence implements SequenceInterface, IteratorAggregate
{
    /**
     * Sequence.
     *
     * @var array<int, ItemInterface>
     */
    private array $items;

    /**
     * Constructor.
     *
     * @param array<int, ItemInterface> $items
     */
    public function __construct(array $items = [])
    {
        $this->set($items);
    }

    /**
     * Defines the sequence.
     *
     * @param array<int, ItemInterface> $items
     */
    public function set(array $items): void
    {
        $this->items = [];

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Adds an item.
     */
    public function add(ItemInterface $item): void
    {
        $this->items[$item->getName()] = $item;
    }

    /**
     * Returns an item by a name.
     */
    public function get(string $name): ?ItemInterface
    {
        return $this->items[$name] ?? null;
    }

    /**
     * Returns all items.
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
