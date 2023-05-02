<?php

declare(strict_types=1);

namespace Cross\Tests\Plugin;

use Cross\Tests\Commands\InitialCommandStub;

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
