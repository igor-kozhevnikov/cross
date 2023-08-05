<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Sequence\SequenceInterface;
use Cross\Sequence\SequenceKeeper;
use Cross\Statuses\Exist;
use Symfony\Component\Console\Input\ArrayInput;

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
            if ($item->isNotUse()) {
                continue;
            }

            $command = $this->getApplication()->find($item->getCommand());
            $input = new ArrayInput($item->getInput());
            $code = $command->run($input, $this->output());
            $exist = Exist::makeByCode($code);

            if (Exist::isNotEqualSuccess($exist)) {
                return $exist;
            }
        }

        return Exist::Success;
    }
}
