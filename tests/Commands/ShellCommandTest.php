<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\ShellCommand;
use Cross\Statuses\Exist;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Process\Process;
use Tests\TestCase;

#[CoversClass(ShellCommand::class)]
final class ShellCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a shell command')]
    public function command(): void
    {
        $command = 'discover';

        $shell = new ShellCommandTemplate();
        $shell->command = $command;

        $this->assertSame($command, $shell->command());
    }

    #[Test]
    #[TestDox('Getting a shell CWD')]
    public function cwd(): void
    {
        $cwd = '~/milky-way-galaxy/';

        $shell = new ShellCommandTemplate();
        $shell->cwd = $cwd;

        $this->assertSame($cwd, $shell->cwd());
    }

    #[Test]
    #[TestDox('Getting a shell TTY')]
    public function tty(): void
    {
        $tty = (bool) rand(0, 1);

        $shell = new ShellCommandTemplate();
        $shell->tty = $tty;

        $this->assertSame($tty, $shell->tty());
    }

    #[Test]
    #[TestDox('Getting a command timeout')]
    public function timeout(): void
    {
        $timeout = 10.5;

        $shell = new ShellCommandTemplate();
        $shell->timeout = $timeout;

        $this->assertSame($timeout, $shell->timeout());
    }

    #[Test]
    #[TestDox('Getting a command ENV')]
    public function env(): void
    {
        $env = ['black-holes' => true];

        $shell = new ShellCommandTemplate();
        $shell->env = $env;

        $this->assertSame($env, $shell->env());
    }

    #[Test]
    #[TestDox('Making a Process instance from a string')]
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
    #[TestDox('Making a Process instance from an array')]
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

        $wrapper = array_map(fn (string $command): string => "'$command'", $shell->command);
        $expect = join(' ', $wrapper);

        $this->assertSame($expect, $process->getCommandLine());
    }

    #[Test]
    #[TestDox('Configuring a Process instance via the configureProcess() method')]
    public function configure(): void
    {
        $tty = (bool) rand(0, 1);
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
    #[TestDox('Executing the handle() method and get default success result')]
    public function handle(): void
    {
        $shell = new ShellCommandTemplate();
        $shell->command = [];

        $this->assertSame(Exist::Success, $shell->handle());
    }
}
