<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Composer;

use Cross\Composer\Composer;
use Cross\Tests\Utils\Accessible;

/**
 * @method array fetchConfig()
 * @method void setConfig(array $config)
 */
class ComposerStub extends Composer
{
    use Accessible;

    /**
     * Composer config path.
     */
    public ?string $path = null;

    /**
     * @inheritDoc
     */
    public function getConfigPath(): string
    {
        return $this->path ?? parent::getConfigPath();
    }
}
