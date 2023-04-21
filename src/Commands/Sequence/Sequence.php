<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

class Sequence implements SequenceInterface
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
     * @inheritDoc
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
    public function add(ItemInterface $item): void
    {
        $this->items[$item->getName()] = $item;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): ?ItemInterface
    {
        return $this->items[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->items;
    }
}
