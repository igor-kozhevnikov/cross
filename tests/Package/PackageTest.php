<?php

declare(strict_types=1);

namespace Tests\Package;

use Cross\Package\Exceptions\InvalidAlternativeConfigException;
use Cross\Package\Package;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;

#[CoversClass(Package::class)]
#[IgnoreClassForCodeCoverage(InvalidAlternativeConfigException::class)]
final class PackageTest extends TestCase
{
    #[Test]
    #[TestDox('Getting the correct base configuration')]
    public function baseConfig(): void
    {
        $package = new PackageStub();
        $config = $package->fetchBaseConfig();

        $this->assertIsArray($config);
        $this->assertSame([], $config['plugins']);
        $this->assertSame([], $config['commands']);
    }

    #[Test]
    #[TestDox('Getting the initial alternative config')]
    public function alternativeConfigMissing(): void
    {
        $package = new PackageStub();

        $this->assertSame([], $package->fetchAlternativeConfig());
    }

    #[Test]
    #[TestDox('Getting a valid alternative config')]
    public function alternativeConfigValid(): void
    {
        $path = $this->makeFile('valid-alternative-config.php', "<?php return ['enable' => true];");

        $package = new PackageStub($path);

        $this->assertSame(['enable' => true], $package->fetchAlternativeConfig($path));
    }

    #[Test]
    #[TestDox('Getting an invalid alternative config')]
    public function alternativeConfigInvalid(): void
    {
        $this->expectException(InvalidAlternativeConfigException::class);

        $path = $this->makeFile('invalid-alternative-config.php', '<?php return null;');

        new Package($path);
    }

    #[Test]
    #[TestDox('Getting the initial configuration')]
    public function config(): void
    {
        $package = new PackageStub();
        $config = ['plugins' => [], 'commands' => []];

        $this->assertSame($config, $package->config);
    }

    #[Test]
    #[TestDox('Getting the initial list of plugins')]
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
