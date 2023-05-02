<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute\Option;

use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Tests\Utils\Str;

class OptionStub extends Option
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(Str::random());
    }
}
