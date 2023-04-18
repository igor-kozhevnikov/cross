<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Stubs;

use Exception;
use Symfony\Component\Console\Command\Command as BaseCommand;

class Command extends BaseCommand
{
    /**
     * Constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct(base64_encode(random_bytes(10)));
    }
}
