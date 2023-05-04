<?php

declare(strict_types=1);

namespace Templates\Commands\Sequence\Item;

use Cross\Commands\Sequence\Item\SequenceItemFactory;
use Cross\Commands\Sequence\Sequence;
use Cross\Commands\Sequence\SequenceInterface;

class SequenceItemFactoryTemplate
{
    use SequenceItemFactory;

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
