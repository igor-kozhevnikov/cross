<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Cases;

use Cross\Commands\SequenceCommand;
use Cross\Sequence\Sequence;
use Cross\Sequence\SequenceInterface;

class Cup extends SequenceCommand
{
    /**
     * @inheritDoc
     */
    protected string $name = 'cup';

    protected function sequence(): SequenceInterface
    {
        return Sequence::make();
    }
}
