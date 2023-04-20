<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Plugin;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Utils\Str;

class BasePluginStub extends BasePlugin
{
    /**
     * Constructor.
     */
    public function __construct(
        public string $key = '',
        public array $config = [],
        public array $commands = [],
    ) {
        $this->key = $key ?: Str::random();
    }
}
