<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\Sequence\Item;
use Cross\Tests\Utils\Str;

class SequenceableCommandStub extends Item
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(Str::random());
    }
}
