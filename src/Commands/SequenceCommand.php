<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\Statuses\Exist;

abstract class SequenceCommand extends BaseCommand
{
    /**
     * Defines the sequence.
     */
    abstract protected function sequence(): SequenceInterface;

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        foreach ($this->sequence()->all() as $command) {
            $status = $this->call($command->getName(), $command->getInput());

            if (Exist::isNotSuccess($status)) {
                return $status;
            }
        }

        return Exist::Success;
    }
}
