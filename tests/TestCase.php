<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Helpers\FileHelper;

class TestCase extends BaseTestCase
{
    /**
     * Returns reflection helper.
     */
    public function file(): FileHelper
    {
        return new FileHelper();
    }
}
