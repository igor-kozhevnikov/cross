<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes\Attribute\Argument;

use Cross\Commands\Attributes\Attribute\Argument\Argument;

class ArgumentStub extends Argument
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(base64_encode(random_bytes(10)));
    }
}
