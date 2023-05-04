<?php

declare(strict_types=1);

namespace Templates\Commands\Sequence\Item;

use Cross\Commands\Sequence\Item\SequenceItem;

class SequenceItemTemplate extends SequenceItem
{
    /**
     * @inheritDoc
     */
    public function __construct(string $name = null)
    {
        parent::__construct($this->name = $name ?: (string) rand());
    }
}
