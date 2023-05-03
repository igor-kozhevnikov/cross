<?php

declare(strict_types=1);

namespace Templates\Plugins;

use Cross\Plugin\BasePlugin;
use Symfony\Component\Console\Command\Command;
use Templates\Accessible;
use Templates\Commands\InitialCommandTemplate;

/**
 * @property string $key
 * @property array $config
 * @property array $commands
 */
class PluginTemplate extends BasePlugin
{
    use Accessible;

    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    protected array $config = ['timeout' => 200];

    /**
     * Commands.
     *
     * @var array<array-key, class-string|Command>
     */
    protected array $commands = [InitialCommandTemplate::class];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->key = (string) rand();
    }
}
