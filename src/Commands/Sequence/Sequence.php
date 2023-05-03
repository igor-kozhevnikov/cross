<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string, SequenceItemInterface>
 */
class Sequence implements SequenceInterface, IteratorAggregate
{
    /**
     * Sequence.
     *
     * @var array<string, SequenceItemInterface>
     */
    private array $items;

    /**
     * Constructor.
     *
     * @param array<string, SequenceItemInterface> $items
     */
    public function __construct(array $items = [])
    {
        $this->set($items);
    }

    /**
     * Defines the sequence.
     *
     * @param array<string, SequenceItemInterface> $items
     */
    public function set(array $items): void
    {
        $this->items = [];

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @inheritDoc
     */
    public function add(SequenceItemInterface $item): void
    {
        $this->items[$item->getName()] = $item;
    }

    /**
     * Returns an item by a name.
     */
    public function get(string $name): ?SequenceItemInterface
    {
        return $this->items[$name] ?? null;
    }

    /**
     * Returns all items.
     *
     * @return array<string, SequenceItemInterface>
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     * @return ArrayIterator<string, SequenceItemInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
