<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Cross\Plugin\BasePlugin;
use Symfony\Component\Console\Command\Command;
use Tests\Commands\InitialCommandTemplate;
use Tests\Helpers\Accessible;

/**
 * @property string $key
 */
class BasePluginTemplate extends BasePlugin
{
    use Accessible;

    /**
     * Config.
     *
     * @var array<string, mixed>
     */
    public array $config = ['timeout' => 200];

    /**
     * Commands.
     *
     * @var array<array-key, class-string|Command>
     */
    public array $commands = [InitialCommandTemplate::class];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->key = (string) rand();
    }
}
