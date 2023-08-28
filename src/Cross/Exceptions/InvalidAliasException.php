<?php

declare(strict_types=1);

namespace Cross\Cross\Exceptions;

use RuntimeException;

class InvalidAliasException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('An alias must be a not empty string.');
    }
}
