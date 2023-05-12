<?php

declare(strict_types=1);

namespace Tests\Cross\Commands;

use Cross\Cross\Commands\CopyConfig;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(CopyConfig::class)]
final class CopyConfigTest extends TestCase
{
    /**
     * Source file.
     */
    private string $source;

    /**
     * Destination file.
     */
    private string $destination;

    /**
     * Command.
     */
    private CopyConfigTemplate $command;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->source = __DIR__ . '/../../../config/cross.php';
        $this->destination = __DIR__ . '/../../../phpunit/temp/cross.php';

        unlink($this->destination);

        $this->command = new CopyConfigTemplate();
        $this->command->destination = $this->destination;
    }

    #[Test]
    #[TestDox('Successfully copying config')]
    public function copySuccessfully(): void
    {
        $exist = $this->command->run();

        $this->assertFileExists($this->destination);
        $this->assertTrue($this->command->messages()->hasSuccess());
        $this->assertSame(0, $exist);
    }

    #[Test]
    #[TestDox('Failure copying config due to destination is not valid')]
    public function copyFailure(): void
    {
        $this->command->tty = false;
        $this->command->destination = '';

        $exist = $this->command->run();

        $this->assertFileDoesNotExist($this->destination);
        $this->assertTrue($this->command->messages()->hasError());
        $this->assertSame(1, $exist);
    }

    #[Test]
    #[TestDox('Failure copying config due to config already exists')]
    public function copyFailureAlreadyExists(): void
    {
        shell_exec("cp $this->source $this->destination");

        $exist = $this->command->run();

        $this->assertFileExists($this->destination);
        $this->assertTrue($this->command->messages()->hasError());
        $this->assertSame(1, $exist);
    }
}
