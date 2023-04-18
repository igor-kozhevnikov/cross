<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin\Stubs;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Commands\Stubs\CommandStub;

class PluginStub extends BasePlugin
{
    /**
     * @inheritDoc
     */
    protected array $commands = [
        CommandStub::class,
    ];

    /**
     * Constructor.
     */
    public function __construct(?string $key = null, array $config = [])
    {
        $this->key = $key ?? base64_encode(random_bytes(10));
        $this->config = $config;
    }
}
