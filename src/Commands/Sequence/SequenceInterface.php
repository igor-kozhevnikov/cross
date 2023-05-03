<?php

declare(strict_types=1);

namespace Cross\Commands\Sequence;

use Traversable;

/**
 * @extends Traversable<SequenceItemInterface>
 */
interface SequenceInterface extends Traversable
{
    /**
     * Adds an item.
     */
    public function add(SequenceItemInterface $item): void;
}
