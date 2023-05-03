<?php

declare(strict_types=1);

namespace Templates\Commands\Sequence;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\Sequence\SequenceItem;
use Templates\Accessible;

/**
 * @property SequenceInterface $sequence
 */
class SequenceItemTemplate extends SequenceItem
{
    use Accessible;

    /**
     * @inheritDoc
     */
    public function __construct(string $name = null)
    {
        parent::__construct($this->name = $name ?: (string) rand());
    }
}
