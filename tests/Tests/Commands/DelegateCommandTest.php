<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\DelegateCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Commands\DelegateCommandStub;
use Cross\Tests\Stubs\Commands\ShellCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

#[CoversClass(DelegateCommand::class)]
final class DelegateCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Getting a delegate by a key')]
    public function delegateKey(): void
    {
        $delegate = new ShellCommandStub();

        $application = new Application();
        $application->add($delegate);

        $command = new DelegateCommandStub();
        $command->setApplication($application);
        $command->delegate = $delegate->name();

        $this->assertSame($command->delegate, $command->delegate()->getName());
    }

    #[Test]
    #[TestDox('Getting a command delegate')]
    public function delegateCommand(): void
    {
        $command = new DelegateCommandStub();
        $command->delegate = new ShellCommandStub();

        $this->assertSame($command->delegate, $command->delegate());
    }

    #[Test]
    #[TestDox('Executing the handler() method')]
    public function handler(): void
    {
        $delegate = new ShellCommandStub();
        $delegate->command = [];

        $command = new DelegateCommandStub();
        $command->input = new ArrayInput([]);
        $command->output = new SymfonyStyle($command->input, new BufferedOutput());
        $command->delegate = $delegate;

        $this->assertSame(Exist::Success, $command->handle());
    }
}
