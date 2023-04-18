<?php

declare(strict_types=1);

namespace Cross\Tests\Composer;

use Cross\Composer\Composer;
use Cross\Tests\TestCase;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Composer::class)]
final class ComposerTest extends TestCase
{
    #[Test]
    #[TestDox('Successful extraction of composer config')]
    public function extractSuccess(): void
    {
        $composer = new Composer();
        $config = $composer->extractConfig();

        $this->assertIsArray($config);
    }

    #[Test]
    #[TestDox('Unsuccessful extraction of composer config due to the composer.json file does not exist')]
    public function extractFailedFile(): void
    {
        $this->expectException(Exception::class);

        $composer = new Composer('invalid path');
        $composer->extractConfig();
    }

    #[Test]
    #[TestDox('Unsuccessful extraction of composer config due to composer.json file content is invalid')]
    public function extractFailedContent(): void
    {
        $this->expectException(Exception::class);

        $path = $this->makeFile('invalid-composer.json');

        $composer = new Composer($path);
        $composer->extractConfig();
    }

    #[Test]
    #[TestDox('Set all properties')]
    public function properties(): void
    {
        $name = 'Name';
        $description = 'Description';
        $version = '1.2.3';
        $vendorDirectory = 'vendor';
        $config = ['vendor-dir' => $vendorDirectory];

        $all = compact('name', 'description', 'version', 'config');

        $composer = new Composer();
        $composer->setConfig($all);

        $this->assertSame($name, $composer->getName());
        $this->assertSame($description, $composer->getDescription());
        $this->assertSame($version, $composer->getVersion());
        $this->assertSame($vendorDirectory, $composer->getVendorDirectory());
    }
}
