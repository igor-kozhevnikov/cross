<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin\Cases;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Commands\Cases\Fork;
use Cross\Tests\Commands\Cases\Spoon;

class Tiger extends BasePlugin
{
    /**
     * @inheritDoc
     */
    protected string $key = 'tiger';

    /**
     * @inheritDoc
     */
    protected array $commands = [
        Fork::class,
        Spoon::class,
    ];
}
