<?php

declare(strict_types=1);

namespace Cross\Package\Exceptions;

use Exception;

class InvalidAutoloadConfigException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('Alternative config is invalid.');
    }
}
