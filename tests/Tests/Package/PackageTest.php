<?php

declare(strict_types=1);

namespace Cross\Tests\Package;

use Cross\Package\Package;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Cross\Tests\Utils\File;
use PHPUnit\Framework\TestCase;

#[CoversClass(Package::class)]
final class PackageTest extends TestCase
{
    #[Test]
    #[TestDox('Initialize a config array')]
    public function constructor(): void
    {
        $package = new Package();

        $this->assertIsArray($package->getConfig());
    }

    #[Test]
    #[TestDox('Return the correct base config')]
    public function baseConfig(): void
    {
        $package = new Package();
        $config = $package->getBaseConfig();

        $this->assertIsArray($config);
        $this->assertSame([], $config['plugins']);
        $this->assertSame([], $config['commands']);
    }

    #[Test]
    #[TestDox('Return a missing alternative config')]
    public function alternativeConfigMissing(): void
    {
        $package = new Package();

        $this->assertIsArray($package->getAlternativeConfig());
    }

    #[Test]
    #[TestDox('Return a valid alternative config')]
    public function alternativeConfigValid(): void
    {
        $path = File::temp('valid-alternative-config.php', '<?php return [];');

        $package = new Package($path);

        $this->assertIsArray($package->getAlternativeConfig());
    }

    #[Test]
    #[TestDox('Return an invalid alternative config')]
    public function alternativeConfigInvalid(): void
    {
        $this->expectException(Exception::class);

        $path = File::temp('invalid-alternative-config.php', '<?php return null;');

        new Package($path);
    }

    #[Test]
    #[TestDox('Return a list of plugins')]
    public function plugins(): void
    {
        $package = new Package();

        $this->assertIsArray($package->getPlugins());
    }

    #[Test]
    #[TestDox('Return a list of commands')]
    public function commands(): void
    {
        $package = new Package();

        $this->assertIsArray($package->getCommands());
    }
}
