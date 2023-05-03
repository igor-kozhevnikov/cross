<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\ShellCommand;
use Cross\Commands\Statuses\Exist;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Process\Process;
use Templates\Commands\ShellCommandTemplate;
use Tests\TestCase;

#[CoversClass(ShellCommand::class)]
final class ShellCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Getting simple properties')]
    public function properties(): void
    {
        $command = 'discover';
        $cwd = '~/milky-way-galaxy/';
        $tty = false;
        $timeout = 10.5;
        $env = ['black-holes' => true];

        $shell = new ShellCommandTemplate();
        $shell->command = $command;
        $shell->cwd = $cwd;
        $shell->tty = $tty;
        $shell->timeout = $timeout;
        $shell->env = $env;

        $this->assertSame($command, $shell->command());
        $this->assertSame($cwd, $shell->cwd());
        $this->assertSame($tty, $shell->tty());
        $this->assertSame($timeout, $shell->timeout());
        $this->assertSame($env, $shell->env());
    }

    #[Test]
    #[TestDox('Making a process from a string')]
    public function processFromString(): void
    {
        $command = 'dance';
        $cwd = '~/house-of-the-great-gatsby';

        $shell = new ShellCommandTemplate();
        $shell->command = $command;
        $shell->cwd = $cwd;

        $process = $shell->makeProcess();

        $this->assertInstanceOf(Process::class, $process);
        $this->assertSame($cwd, $process->getWorkingDirectory());
        $this->assertSame($command, $process->getCommandLine());
    }

    #[Test]
    #[TestDox('Making a process from an array')]
    public function processFormArray(): void
    {
        $command = ['fight', 'kill'];
        $cwd = '~/mortal-kombat-arena';

        $shell = new ShellCommandTemplate();
        $shell->command = $command;
        $shell->cwd = $cwd;

        $process = $shell->makeProcess();

        $this->assertInstanceOf(Process::class, $process);
        $this->assertSame($cwd, $process->getWorkingDirectory());

        $this->assertSame(
            join(' ', array_map(fn (string $command): string => "'$command'", $shell->command)),
            $process->getCommandLine(),
        );
    }

    #[Test]
    #[TestDox('Configuring a process')]
    public function configure(): void
    {
        $tty = true;
        $timeout = 200.5;
        $env = ['luck' => true];

        $process = new Process([]);

        $shell = new ShellCommandTemplate();
        $shell->tty = $tty;
        $shell->timeout = $timeout;
        $shell->env = $env;

        $shell->configureProcess($process);

        $this->assertSame($tty, $process->isTty());
        $this->assertSame($timeout, $process->getTimeout());
        $this->assertSame($env, $process->getEnv());
    }

    #[Test]
    #[TestDox('Executing the handle() method')]
    public function handle(): void
    {
        $shell = new ShellCommandTemplate();
        $shell->command = [];

        $this->assertSame(Exist::Success, $shell->handle());
    }
}
