<?php

declare(strict_types=1);

namespace Cross\Commands;

use Cross\Commands\Statuses\Exist;
use Symfony\Component\Console\Command\Command;

abstract class DelegateCommand extends BaseCommand
{
    /**
     * Delegate.
     */
    protected string|Command $delegate;

    /**
     * Returns a delegate.
     */
    protected function delegate(): string|Command
    {
        if (is_string($this->delegate)) {
            return $this->getApplication()->find($this->delegate);
        }

        return $this->delegate;
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        $command = $this->delegate();
        $code = $command->run($this->input(), $this->output());

        return Exist::from($code);
    }
}
