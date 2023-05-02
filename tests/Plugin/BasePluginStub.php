<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Cross\Plugin\BasePlugin;
use Cross\Utils\Accessible;

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
        $this->key = base64_encode(random_bytes(10));
    }
}
