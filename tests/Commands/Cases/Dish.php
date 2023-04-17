<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Cases;

use Cross\Commands\IOCommand;

class Dish extends IOCommand
{
    /**
     * @inheritDoc
     */
    protected string $name = 'dish';
}
