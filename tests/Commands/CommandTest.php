<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Command;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreMethodForCodeCoverage;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

#[CoversClass(Command::class)]
#[IgnoreMethodForCodeCoverage(Command::class, 'info')]
#[IgnoreMethodForCodeCoverage(Command::class, 'comment')]
#[IgnoreMethodForCodeCoverage(Command::class, 'ask')]
#[IgnoreMethodForCodeCoverage(Command::class, 'choice')]
#[IgnoreMethodForCodeCoverage(Command::class, 'confirm')]
final class CommandTest extends TestCase
{
    #[Test]
    #[TestDox('Initialize an input and output')]
    public function initialize(): void
    {
        $command = new CommandStub();
        $command->call();

        $this->assertInstanceOf(InputInterface::class, $command->input());
        $this->assertInstanceOf(SymfonyStyle::class, $command->output());
    }

    #[Test]
    #[TestDox('Output error messages')]
    public function errors(): void
    {
        $command = new CommandStub();
        $command->call();

        $this->assertSame(Exist::Failure, $command->errors([]));
        $this->assertSame(Exist::Failure, $command->errors(['message']));
    }

    #[Test]
    #[TestDox('Output an error message')]
    public function error(): void
    {
        $command = new CommandStub();
        $command->call();

        $this->assertSame(Exist::Failure, $command->error('message'));
        $this->assertSame(Exist::Failure, $command->error('message', 'info'));
    }

    #[Test]
    #[TestDox('Output a success message')]
    public function success(): void
    {
        $command = new CommandStub();
        $command->call();

        $this->assertSame(Exist::Success, $command->success());
        $this->assertSame(Exist::Success, $command->success('message'));
        $this->assertSame(Exist::Success, $command->success(['message', 'message']));
    }

    #[Test]
    #[TestDox('Return arguments')]
    public function arguments(): void
    {
        $command = new CommandStub();
        $command->addArgument('counter', default: 10);
        $command->call();

        $this->assertSame(['counter' => 10], $command->arguments());
    }

    #[Test]
    #[TestDox('Return an argument')]
    public function argument(): void
    {
        $command = new CommandStub();
        $command->addArgument('counter', default: 10);
        $command->call();

        $this->assertSame(10, $command->argument('counter'));
        $this->assertSame(null, $command->argument('undefined'));
    }

    #[Test]
    #[TestDox('Return options')]
    public function options(): void
    {
        $command = new CommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->call();

        $this->assertSame(['counter' => 10], $command->options());
    }

    #[Test]
    #[TestDox('Return an option')]
    public function option(): void
    {
        $command = new CommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->call();

        $this->assertSame(10, $command->option('counter'));
        $this->assertSame(null, $command->option('undefined'));
    }


    #[Test]
    #[TestDox('Return a value depend on a positive option')]
    public function whenOption(): void
    {
        $command = new CommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->call();

        $this->assertSame('P', $command->whenOption('counter', 'P', 'N'));
        $this->assertSame('N', $command->whenOption('undefined', 'P', 'N'));
    }

    #[Test]
    #[TestDox('Return a value depend on a negative option')]
    public function whenNotOption(): void
    {
        $command = new CommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->call();

        $this->assertSame('N', $command->whenNotOption('counter', 'P', 'N'));
        $this->assertSame('P', $command->whenNotOption('undefined', 'P', 'N'));
    }
}
