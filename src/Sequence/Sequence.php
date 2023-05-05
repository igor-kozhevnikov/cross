<?php

declare(strict_types=1);

namespace Cross\Sequence;

use Cross\Sequence\Item\ItemFactory;
use Cross\Sequence\Item\ItemInterface;

class Sequence implements SequenceInterface
{
    use ItemFactory;

    /**
     * Items.
     *
     * @var array<string, ItemInterface>
     */
    private array $items;

    /**
     * Constructor.
     *
     * @param array<string, ItemInterface> $commands
     */
    public function __construct(array $commands = [])
    {
        $this->set($commands);
    }

    /**
     * Makes an instance.
     */
    public static function make(): self
    {
        return new self();
    }

    /**
     * Defines the sequence.
     *
     * @param array<string, ItemInterface> $items
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
        $this->items[$item->getCommand()] = $item;
    }

    /**
     * Returns a command by a name.
     */
    public function get(string $command): ?ItemInterface
    {
        return $this->items[$command] ?? null;
    }

    /**
     * Returns all commands.
     *
     * @return array<string, ItemInterface>
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
