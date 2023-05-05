<?php

declare(strict_types=1);

namespace Cross\Sequence\Item;

use Cross\Sequence\SequenceInterface;

trait ItemFactory
{
    /**
     * Return a sequence.
     */
    abstract public function getSequence(): SequenceInterface;

    /**
     * Makes an item.
     */
    public function item(string $command): Item
    {
        if (class_exists($command) && method_exists($command, 'getName')) {
            $command = (new $command())->getName();
        }

        $item = new Item($command);
        $item->setSequence($this->getSequence());

        $this->getSequence()->add($item);

        return $item;
    }
}
