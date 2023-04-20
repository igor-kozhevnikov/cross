<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\Sequence\Command;
use Cross\Tests\Utils\Str;

class SequenceCommandCommandStub extends Command
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(Str::random());
    }
}
