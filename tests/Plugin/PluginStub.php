<?php

declare(strict_types=1);

namespace Tests\Plugin;

use Tests\Commands\InitialCommandStub;

class PluginStub extends BasePluginStub
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->commands = [InitialCommandStub::class];
    }
}
