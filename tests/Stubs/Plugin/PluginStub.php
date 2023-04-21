<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Plugin;

use Cross\Tests\Stubs\Commands\PrimaryCommandStub;

class PluginStub extends BasePluginStub
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->commands = [PrimaryCommandStub::class];
    }
}
