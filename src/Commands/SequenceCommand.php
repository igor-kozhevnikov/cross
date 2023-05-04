<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Sequence\SequenceInterface;
use Cross\Commands\Sequence\SequenceKeeper;
use Cross\Commands\Statuses\Exist;

abstract class SequenceCommand extends BaseCommand
{
    /**
     * Returns a sequence.
     */
    abstract protected function sequence(): SequenceInterface|SequenceKeeper;

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        $sequence = $this->sequence();

        if ($sequence instanceof SequenceKeeper) {
            $sequence = $sequence->getSequence();
        }

        foreach ($sequence->getAll() as $item) {
            $command = $this->getApplication()->find($item->getName());
            $code = $command->run($this->input(), $this->output());
            $exist = Exist::from($code);

            if (Exist::isNotSuccess($exist)) {
                return $exist;
            }
        }

        return Exist::Success;
    }
}
