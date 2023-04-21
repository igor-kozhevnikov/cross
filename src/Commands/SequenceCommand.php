<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\Statuses\Exist;

abstract class SequenceCommand extends BaseCommand
{
    /**
     * Returns a sequence.
     */
    abstract protected function sequence(): SequenceInterface;

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        foreach ($this->sequence() as $command) {
            $command = $this->getApplication()->find($command->getName());
            $code = $command->run($this->input(), $this->output());
            $exist = Exist::from($code);

            if (Exist::isNotSuccess($exist)) {
                return $exist;
            }
        }

        return Exist::Success;
    }
}
