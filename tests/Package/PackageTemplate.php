<?php

declare(strict_types=1);

namespace Tests\Package;

use Cross\Package\Config\Extension;
use Cross\Package\Package;
use Tests\Helpers\Accessible;

/**
 * @method array fetchBaseConfig()
 * @method array fetchAlternativeConfig()
 */
class PackageTemplate extends Package
{
    use Accessible;

    /**
     * Extension.
     */
    public ?Extension $extension = null;

    /**
     * Base config path.
     */
    public ?string $base = null;

    /**
     * Alternative config path.
     */
    public ?string $alternative = null;

    /**
     * @inheritDoc
     */
    public function getBaseConfigPath(Extension|string $extension): string
    {
        return $this->base ?? parent::getBaseConfigPath($extension);
    }

    /**
     * @inheritDoc
     */
    protected function getAvailableAlternativeConfigExtension(): ?Extension
    {
        return $this->extension ?? parent::getAvailableAlternativeConfigExtension();
    }

    /**
     * @inheritDoc
     */
    public function getAlternativeConfigPath(Extension|string $extension): string
    {
        return $this->alternative ?? parent::getAlternativeConfigPath($extension);
    }
}
