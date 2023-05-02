<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes\Attribute\Option;

use Cross\Commands\Attributes\Attribute\Option\Option;

class OptionStub extends Option
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(base64_encode(random_bytes(10)));
    }
}
