<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands\Attrubutes\Attribute\Argument;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use Cross\Tests\Utils\Str;

class ArgumentStub extends Argument
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(Str::random());
    }
}
