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
     * Static constructor.
     *
     * @param array<int, ItemInterface> $item
     */
    public static function make(array $item = []): self
    {
        return new self($item);
    }

    /**
     * @inheritDoc
     */
    public function set(array $items): self
    {
        $this->items = [];

        foreach ($items as $item) {
            $this->add($item);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function add(ItemInterface $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function item(string $name): ItemInterface
    {
        return Item::make($name)->sequence($this);
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->items;
    }
}
