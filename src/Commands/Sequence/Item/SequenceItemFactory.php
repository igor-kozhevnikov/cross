<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence\Item;

use Cross\Commands\Sequence\SequenceInterface;

trait SequenceItemFactory
{
    /**
     * Return a sequence.
     */
    abstract public function getSequence(): SequenceInterface;

    /**
     * Makes an item.
     */
    public function item(string $name): SequenceItem
    {
        $item = new SequenceItem($name);
        $item->setSequence($this->getSequence());

        $this->getSequence()->add($item);

        return $item;
    }
}
