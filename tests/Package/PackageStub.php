<?php

declare(strict_types=1);

namespace Tests\Package;

use Cross\Package\Package;
use Cross\Utils\Accessible;

/**
 * @property array $config
 *
 * @method array fetchAlternativeConfig(?string $alternative = null)
 * @method array fetchBaseConfig()
 */
class PackageStub extends Package
{
    use Accessible;
}
