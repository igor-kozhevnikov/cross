<?php

declare(strict_types=1);

namespace Cross\Tests\Composer;

use Cross\Composer\Composer;
use Cross\Composer\Exceptions\InvalidComposerConfigException;
use Cross\Composer\Exceptions\MissingComposerConfigException;
use Cross\Tests\Stubs\Composer\ComposerStub;
use Cross\Tests\Utils\File;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreClassForCodeCoverage;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Composer::class)]
#[IgnoreClassForCodeCoverage(InvalidComposerConfigException::class)]
#[IgnoreClassForCodeCoverage(MissingComposerConfigException::class)]
final class ComposerTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a composer config path')]
    public function configPath(): void
    {
        $composer = new ComposerStub();

        $this->assertSame(getcwd() . '/composer.json', $composer->getConfigPath());
    }

    #[Test]
    #[TestDox('Successful fetching of composer config')]
    public function configSuccess(): void
    {
        $config = (new ComposerStub())->fetchConfig();

        $this->assertIsArray($config);
        $this->assertIsString($config['name']);
        $this->assertIsString($config['description']);
        $this->assertIsString($config['version']);
        $this->assertNull($config['vendor-dir']);
    }

    #[Test]
    #[TestDox('Unsuccessful fetching of composer config due to the composer.json file does not exist')]
    public function configMissing(): void
    {
        $this->expectException(MissingComposerConfigException::class);

        $composer = new ComposerStub();
        $composer->path = '~/andromeda-galaxy/composer.json';
        $composer->fetchConfig();
    }

    #[Test]
    #[TestDox('Unsuccessful fetching of composer config due to composer.json file content is invalid')]
    public function configInvalid(): void
    {
        $this->expectException(InvalidComposerConfigException::class);

        $path = File::temp('invalid-composer.json');

        $composer = new ComposerStub();
        $composer->path = $path;
        $composer->fetchConfig();
    }

    #[Test]
    #[TestDox('Defining the all properties')]
    public function properties(): void
    {
        $name = 'Name';
        $description = 'Description';
        $version = '1.2.3';
        $vendorDirectory = 'vendor';
        $config = ['vendor-dir' => $vendorDirectory];

        $all = compact('name', 'description', 'version', 'config');

        $composer = new ComposerStub();
        $composer->setConfig($all);

        $this->assertSame($name, $composer->getName());
        $this->assertSame($description, $composer->getDescription());
        $this->assertSame($version, $composer->getVersion());
        $this->assertSame($vendorDirectory, $composer->getVendorDirectory());
    }
}
