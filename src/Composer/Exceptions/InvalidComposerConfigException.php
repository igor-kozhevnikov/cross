<?php

declare(strict_types=1);

namespace Cross\Composer\Exceptions;

use Exception;

class InvalidComposerConfigException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('The composer.json file is invalid');
    }
}
