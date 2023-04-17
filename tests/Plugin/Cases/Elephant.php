<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin\Cases;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Commands\Cases\Cup;
use Cross\Tests\Commands\Cases\Knife;

class Elephant extends BasePlugin
{
    /**
     * @inheritDoc
     */
    protected string $key = 'elephant';

    /**
     * @inheritDoc
     */
    protected array $commands = [
        Cup::class,
        Knife::class,
    ];
}
