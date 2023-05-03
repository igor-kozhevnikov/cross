<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

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
