<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin\Stubs;

use Cross\Plugin\BasePlugin;
use Cross\Tests\Commands\Stubs\Command;
use Exception;

class Plugin extends BasePlugin
{
    /**
     * @inheritDoc
     */
    protected array $commands = [
        Command::class,
    ];

    /**
     * Constructor.
     * @throws Exception
     */
    public function __construct(?string $key = null, array $config = [])
    {
        $this->key = $key ?? base64_encode(random_bytes(10));
        $this->config = $config;
    }
}
