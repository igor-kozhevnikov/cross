<?php

declare(strict_types=1);

namespace Tests\Sequence\Item;

use Cross\Sequence\Item\ItemFactory;
use Cross\Sequence\Sequence;
use Cross\Sequence\SequenceInterface;

class ItemFactoryTemplate
{
    use ItemFactory;

    /**
     * Sequence.
     */
    protected SequenceInterface $sequence;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->sequence = new Sequence();
    }

    /**
     * @inheritDoc
     */
    public function getSequence(): SequenceInterface
    {
        return $this->sequence;
    }
}
