<?php

declare(strict_types=1);

namespace Cross\Composer\Exceptions;

use Exception;

class MissingComposerConfigException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('The composer.json file does not exist');
    }
}
