<?php

declare(strict_types=1);

namespace Cross\Composer\Exceptions;

use Exception;

class InvalidComposerConfigException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct(string $path)
    {
        parent::__construct("The $path file is invalid");
    }
}
