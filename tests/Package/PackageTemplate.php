<?php

declare(strict_types=1);

namespace Tests\Package;

use Cross\Package\Package;
use Tests\Helpers\Accessible;

/**
 * @method array fetchBaseConfig()
 * @method array fetchAlternativeConfig(?string $path = null)
 */
class PackageTemplate extends Package
{
    use Accessible;
}
