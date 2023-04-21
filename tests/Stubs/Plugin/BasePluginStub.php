<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Plugin;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Utils\Accessible;
use Cross\Tests\Utils\Str;

/**
 * @property string $key
 * @property array $config
 * @property array $commands
 */
class BasePluginStub extends BasePlugin
{
    use Accessible;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->key = Str::random();
    }
}
