<?php

declare(strict_types=1);

namespace Tests\Commands\Sequence;

use Cross\Commands\Sequence\Item;
use Cross\Commands\Sequence\SequenceInterface;
use Cross\Utils\Accessible;

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
        $this->setName(base64_encode(random_bytes(10)));
    }
}
