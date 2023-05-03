<?php

declare(strict_types=1);

namespace Templates\Packages;

use Cross\Package\Package;
use Templates\Accessible;

/**
 * @method array fetchBaseConfig()
 * @method array fetchAlternativeConfig(?string $alternative = null)
 */
class PackageTemplate extends Package
{
    use Accessible;
}
