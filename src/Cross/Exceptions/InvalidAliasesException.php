<?php

declare(strict_types=1);

namespace Cross\Cross\Exceptions;

use RuntimeException;

class InvalidAliasesException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The "aliases" config property must be an array of strings or a string.');
    }
}
