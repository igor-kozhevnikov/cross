<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Cases;

use Cross\Commands\ShellCommand;

class Knife extends ShellCommand
{
    /**
     * @inheritDoc
     */
    protected string $name = 'knife';
}
