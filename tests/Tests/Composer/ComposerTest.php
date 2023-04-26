<?php

declare(strict_types=1);

namespace Cross\Tests\Composer;

use Cross\Composer\Composer;
use Cross\Composer\Exceptions\InvalidComposerConfigException;
use Cross\Composer\Exceptions\MissingComposerConfigException;
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
    /**
     * Path to a composer config.
     */
    private static string $path;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        self::$path = getcwd() . '/composer.json';
    }

    #[Test]
    #[TestDox('Successful fetching of composer config')]
    public function configSuccess(): void
    {
        $config = (new Composer(self::$path))->getConfig();

        $this->assertIsArray($config);
        $this->assertIsString($config['description']);
        $this->assertIsString($config['version']);
        $this->assertNull($config['config']['vendor-dir']);
    }

    #[Test]
    #[TestDox('Unsuccessful fetching of composer config due to the composer.json file does not exist')]
    public function configMissing(): void
    {
        $this->expectException(MissingComposerConfigException::class);

        $path = '~/andromeda-galaxy/composer.json';

        new Composer($path);
    }

    #[Test]
    #[TestDox('Unsuccessful fetching of composer config due to composer.json file content is invalid')]
    public function configInvalid(): void
    {
        $this->expectException(InvalidComposerConfigException::class);

        $path = File::temp('invalid-composer.json');

        new Composer($path);
    }

    #[Test]
    #[TestDox('Getting config')]
    public function config(): void
    {
        $composer = new Composer(self::$path);
        $config = $composer->getConfig();

        $this->assertIsArray($config);
    }

    #[Test]
    #[TestDox('Getting a description')]
    public function description(): void
    {
        $composer = new Composer(self::$path);
        $config = $composer->getConfig();

        $this->assertSame($config['description'], $composer->getDescription());
    }

    #[Test]
    #[TestDox('Getting a version')]
    public function version(): void
    {
        $composer = new Composer(self::$path);
        $config = $composer->getConfig();

        $this->assertSame($config['version'], $composer->getVersion());
    }

    #[Test]
    #[TestDox('Getting a vendor directory')]
    public function vendor(): void
    {
        $composer = new Composer(self::$path);

        $this->assertSame('vendor', $composer->getVendorDirectory());
    }
}
