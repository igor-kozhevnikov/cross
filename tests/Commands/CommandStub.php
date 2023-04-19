<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Symfony\Component\Console\Command\Command;

class CommandStub extends Command
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(base64_encode(random_bytes(10)));
    }
}
