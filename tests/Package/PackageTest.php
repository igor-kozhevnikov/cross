<?php

declare(strict_types=1);

namespace Tests\Package;

use Cross\Package\Exceptions\InvalidAlternativeConfigException;
use Cross\Package\Package;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Templates\Packages\PackageTemplate;
use Tests\TestCase;

#[CoversClass(Package::class)]
#[IgnoreClassForCodeCoverage(InvalidAlternativeConfigException::class)]
final class PackageTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a correct base config')]
    public function baseConfig(): void
    {
        $package = new PackageTemplate();

        $config = $package->fetchBaseConfig();

        $this->assertIsArray($config);
        $this->assertSame([], $config['plugins']);
        $this->assertSame([], $config['commands']);
    }

    #[Test]
    #[TestDox('Getting an initial alternative config')]
    public function alternativeConfigMissing(): void
    {
        $package = new PackageTemplate();

        $this->assertSame([], $package->fetchAlternativeConfig());
    }

    #[Test]
    #[TestDox('Getting a valid alternative config')]
    public function alternativeConfigValid(): void
    {
        $path = $this->file()
            ->name('valid-alternative-config.php')
            ->content("<?php return ['enable' => true];")
            ->make()
            ->getPath();

        $package = new PackageTemplate($path);

        $this->assertSame(['enable' => true], $package->fetchAlternativeConfig($path));
    }

    #[Test]
    #[TestDox('Getting an invalid alternative config')]
    public function alternativeConfigInvalid(): void
    {
        $this->expectException(InvalidAlternativeConfigException::class);

        $path = $this->file()
            ->name('invalid-alternative-config.php')
            ->content('<?php return null;')
            ->make()
            ->getPath();

        new Package($path);
    }

    #[Test]
    #[TestDox('Getting the initial configuration')]
    public function config(): void
    {
        $config = ['plugins' => [], 'commands' => []];

        $package = new Package();

        $this->assertSame($config, $package->getConfig());
    }

    #[Test]
    #[TestDox('Getting an initial list of plugins')]
    public function plugins(): void
    {
        $package = new Package();

        $this->assertSame([], $package->getPlugins());
    }

    #[Test]
    #[TestDox('Getting the initial list of commands')]
    public function commands(): void
    {
        $package = new Package();

        $this->assertSame([], $package->getCommands());
    }
}
