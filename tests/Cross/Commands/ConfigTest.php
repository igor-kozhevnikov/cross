<?php

declare(strict_types=1);

namespace Tests\Cross\Commands;

use Cross\Cross\Commands\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Tests\Package\PackageTemplate;

#[CoversClass(Config::class)]
final class ConfigTest extends TestCase
{
    /**
     * Destination file.
     */
    private PackageTemplate $package;

    /**
     * Command.
     */
    private ConfigTemplate $command;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->package = new PackageTemplate();
        $this->package->base = __DIR__ . '/../../../config/cross.php';
        $this->package->alternative = __DIR__ . '/../../../phpunit/temp/cross.php';

        unlink($this->package->alternative);

        $this->command = new ConfigTemplate();
        $this->command->package = $this->package;
    }

    #[Test]
    #[TestDox('Successfully copying config')]
    public function copySuccessfullyPHP(): void
    {
        $exist = $this->command->run();

        $this->assertFileExists($this->package->alternative);
        $this->assertTrue($this->command->messages()->hasSuccess());
        $this->assertSame(0, $exist);
    }

    #[Test]
    #[TestDox('Successfully copying config')]
    public function copySuccessfullyJSON(): void
    {
        $this->package->base = __DIR__ . '/../../../config/cross.json';
        $this->package->alternative = __DIR__ . '/../../../phpunit/temp/cross.json';

        unlink($this->package->alternative);

        $exist = $this->command->run();

        $this->assertFileExists($this->package->alternative);
        $this->assertTrue($this->command->messages()->hasSuccess());
        $this->assertSame(0, $exist);
    }

    #[Test]
    #[TestDox('Failure copying config due to destination is not valid')]
    public function copyFailureInvalid(): void
    {
        $this->command->tty = false;
        $this->package->alternative = '';

        $exist = $this->command->run();

        $this->assertFileDoesNotExist($this->package->alternative);
        $this->assertTrue($this->command->messages()->hasError());
        $this->assertSame(1, $exist);
    }

    #[Test]
    #[TestDox('Failure copying config due to config already exists')]
    public function copyFailureAlreadyExists(): void
    {
        shell_exec("cp {$this->package->base} {$this->package->alternative}");

        $exist = $this->command->run();

        $this->assertFileExists($this->package->alternative);
        $this->assertTrue($this->command->messages()->hasError());
        $this->assertSame(1, $exist);
    }
}
