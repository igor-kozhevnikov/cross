<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Sequence\SequenceInterface;
use Cross\Status\Status;

abstract class SequenceCommand extends BaseCommand
{
    /**
     * Define the sequence.
     */
    abstract protected function sequence(): SequenceInterface;

    /**
     * @inheritDoc
     */
    protected function handle(): Status
    {
        foreach ($this->sequence()->all() as $command) {
            $status = $this->call($command->getName(), $command->getInput());

            if (Status::isSkip($status)) {
                continue;
            }

            if (Status::isNotSuccess($status)) {
                return $status;
            }
        }

        return Status::Success;
    }
}
