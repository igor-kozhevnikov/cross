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
    #[TestDox('Returns properties')]
    public function properties(): void
    {
        $command = new ShellCommandStub(
            command: 'monkey',
            cwd: 'dir',
            tty: false,
            timeout: 7.5,
            env: ['location' => 'Africa'],
        );

        $this->assertSame($command->command, $command->command());
        $this->assertSame($command->cwd, $command->cwd());
        $this->assertSame($command->tty, $command->tty());
        $this->assertSame($command->timeout, $command->timeout());
        $this->assertSame($command->env, $command->env());
    }

    #[Test]
    #[TestDox('Make a process from a string')]
    public function makeProcessFromString(): void
    {
        $command = new ShellCommandStub(command: 'monkey');

        $this->assertInstanceOf(Process::class, $command->makeProcess());
    }

    #[Test]
    #[TestDox('Make a process from an array')]
    public function makeProcessFormArray(): void
    {
        $command = new ShellCommandStub(command: ['monkey']);

        $this->assertInstanceOf(Process::class, $command->makeProcess());
    }

    #[Test]
    #[TestDox('Handle the command')]
    public function handle(): void
    {
        $command = new ShellCommandStub();

        $this->assertSame(Exist::Success, $command->handle());
    }
}
