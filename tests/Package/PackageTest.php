<?php

declare(strict_types=1);

namespace Tests\Package;

use Cross\Package\Config\Extension;
use Cross\Package\Exceptions\InvalidAlternativeConfigException;
use Cross\Package\Package;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use ValueError;

#[CoversClass(Package::class)]
#[CoversClass(InvalidAlternativeConfigException::class)]
final class PackageTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a correct base config path')]
    public function baseConfigPathCorrect(): void
    {
        $package = new PackageTemplate();
        $php = $package->getBaseConfigPath('php');
        $json = $package->getBaseConfigPath('json');

        $this->assertIsString($php);
        $this->assertIsString($json);
    }

    #[Test]
    #[TestDox('Getting a invalid base config path')]
    public function baseConfigPathInvalid(): void
    {
        $this->expectException(ValueError::class);

        $package = new PackageTemplate();
        $package->getBaseConfigPath('yaml');
    }

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
    #[TestDox('Getting a correct alternative config path')]
    public function alternativeConfigPathCorrect(): void
    {
        $package = new PackageTemplate();
        $php = $package->getAlternativeConfigPath('php');
        $json = $package->getAlternativeConfigPath('json');

        $this->assertIsString($php);
        $this->assertIsString($json);
    }

    #[Test]
    #[TestDox('Getting a correct alternative config path')]
    public function alternativeConfigPathInvalid(): void
    {
        $this->expectException(ValueError::class);

        $package = new PackageTemplate();
        $package->getAlternativeConfigPath('yaml');
    }

    #[Test]
    #[TestDox('Getting an initial alternative config')]
    public function alternativeConfigMissing(): void
    {
        $package = new PackageTemplate();

        $this->assertSame([], $package->fetchAlternativeConfig());
    }

    #[Test]
    #[TestDox('Getting a valid alternative PHP config')]
    public function alternativeConfigValidPHP(): void
    {
        $path = $this->file()
            ->name('valid-alternative-config.php')
            ->content("<?php return ['enable' => true];")
            ->make()
            ->getPath();

        $package = new PackageTemplate();
        $package->extension = Extension::PHP;
        $package->alternative = $path;

        $this->assertSame(['enable' => true], $package->fetchAlternativeConfig());
    }

    #[Test]
    #[TestDox('Getting a valid alternative JSON config')]
    public function alternativeConfigValidJson(): void
    {
        $path = $this->file()
            ->name('valid-alternative-config.json')
            ->content('{"enable": true}')
            ->make()
            ->getPath();

        $package = new PackageTemplate();
        $package->extension = Extension::JSON;
        $package->alternative = $path;

        $this->assertSame(['enable' => true], $package->fetchAlternativeConfig());
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

        $package = new PackageTemplate();
        $package->alternative = $path;
        $package->configure();
    }

    #[Test]
    #[TestDox('Getting the initial configuration')]
    public function config(): void
    {
        $config = ['autoload' => [], 'plugins' => [], 'commands' => []];

        $package = new Package();
        $package->configure();

        $this->assertSame($config, $package->getConfig());
    }

    #[Test]
    #[TestDox('Autoload another classes')]
    public function autoload(): void
    {
        $this->markTestIncomplete();
    }

    #[Test]
    #[TestDox('Getting an initial list of plugins')]
    public function plugins(): void
    {
        $package = new Package();
        $package->configure();

        $this->assertSame([], $package->getPlugins());
    }

    #[Test]
    #[TestDox('Getting the initial list of commands')]
    public function commands(): void
    {
        $package = new Package();
        $package->configure();

        $this->assertSame([], $package->getCommands());
    }
}
