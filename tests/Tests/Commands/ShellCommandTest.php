<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\ShellCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Commands\ShellCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

#[CoversClass(ShellCommand::class)]
final class ShellCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Getting simple properties')]
    public function properties(): void
    {
        $command = new ShellCommandStub();
        $command->command = 'discover';
        $command->cwd = '~/milky-way-galaxy/';
        $command->tty = false;
        $command->timeout = 10.5;
        $command->env = ['black-holes' => true];

        $this->assertSame($command->command, $command->command());
        $this->assertSame($command->cwd, $command->cwd());
        $this->assertSame($command->tty, $command->tty());
        $this->assertSame($command->timeout, $command->timeout());
        $this->assertSame($command->env, $command->env());
    }

    #[Test]
    #[TestDox('Making a process from a string')]
    public function processFromString(): void
    {
        $command = new ShellCommandStub();
        $command->cwd = '~/house-of-the-great-gatsby';
        $command->command = 'dance';

        $process = $command->makeProcess();

        $this->assertInstanceOf(Process::class, $process);
        $this->assertSame($command->cwd, $process->getWorkingDirectory());
        $this->assertSame($command->command, $process->getCommandLine());
    }

    #[Test]
    #[TestDox('Making a process from an array')]
    public function processFormArray(): void
    {
        $command = new ShellCommandStub();
        $command->cwd = '~/mortal-kombat-arena';
        $command->command = ['fight', 'kill'];

        $process = $command->makeProcess();

        $this->assertInstanceOf(Process::class, $process);
        $this->assertSame($command->cwd, $process->getWorkingDirectory());

        $this->assertSame(
            join(' ', array_map(fn (string $command): string => "'$command'", $command->command)),
            $process->getCommandLine(),
        );
    }

    #[Test]
    #[TestDox('Configuring a process')]
    public function configure(): void
    {
        $process = new Process([]);

        $command = new ShellCommandStub();
        $command->tty = true;
        $command->timeout = 777;
        $command->env = ['luck' => true];
        $command->configureProcess($process);

        $this->assertSame($command->tty, $process->isTty());
        $this->assertSame($command->timeout, $process->getTimeout());
        $this->assertSame($command->env, $process->getEnv());
    }

    #[Test]
    #[TestDox('Executing the handle() method')]
    public function handle(): void
    {
        $command = new ShellCommandStub();
        $command->command = [];

        $this->assertSame(Exist::Success, $command->handle());
    }
}
