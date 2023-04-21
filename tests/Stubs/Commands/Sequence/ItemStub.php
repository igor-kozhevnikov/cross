<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands\Sequence;

use Cross\Commands\Sequence\Item;
use Cross\Commands\Sequence\SequenceInterface;
use Cross\Tests\Utils\Accessible;
use Cross\Tests\Utils\Str;

/**
 * @property SequenceInterface $sequence
 */
class ItemStub extends Item
{
    use Accessible;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setName(Str::random());
    }
}
