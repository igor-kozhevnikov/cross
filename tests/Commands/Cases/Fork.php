<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Cases;

use Cross\Commands\BaseCommand;
use Cross\Status\Status;

class Fork extends BaseCommand
{
    /**
     * @inheritDoc
     */
    protected string $name = 'fork';

    /**
     * @inheritDoc
     */
    protected function handle(): Status
    {
        return Status::Success;
    }
}
