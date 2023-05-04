<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

use Cross\Commands\Sequence\Item\SequenceItemFactory;
use Cross\Commands\Sequence\Item\SequenceItemInterface;

class Sequence implements SequenceInterface
{
    use SequenceItemFactory;

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
     * Makes and returns an instance.
     */
    public static function make(): self
    {
        return new self();
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
    public function getAll(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function getSequence(): SequenceInterface
    {
        return $this;
    }
}
