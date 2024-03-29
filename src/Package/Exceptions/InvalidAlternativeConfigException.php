<?php

declare(strict_types=1);

namespace Cross\Package\Exceptions;

use Exception;

class InvalidAlternativeConfigException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('The "autoload" config property must be an array of strings or string.');
    }
}
