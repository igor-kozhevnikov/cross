<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Cases;

use Cross\Commands\DeputyCommand;

class Spoon extends DeputyCommand
{
    /**
     * @inheritDoc
     */
    protected string $name = 'spoon';
}
