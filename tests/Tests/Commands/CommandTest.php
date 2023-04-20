<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Command;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Commands\CommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

#[CoversClass(Command::class)]
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

        $this->assertSame(true, $command->whenOption('counter', true, false));
        $this->assertSame(false, $command->whenOption('undefined', true, false));
    }

    #[Test]
    #[TestDox('Return a value depend on a negative option')]
    public function whenNotOption(): void
    {
        $command = new CommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->call();

        $this->assertSame(false, $command->whenNotOption('counter', true, false));
        $this->assertSame(true, $command->whenNotOption('undefined', true, false));
    }

    #[Test]
    #[TestDox('Call the info method')]
    public function info(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['info'])
            ->getMock();

        $arguments = ['good news'];

        $output->expects($this->once())->method('info')->with(...$arguments);

        $command = new CommandStub($output);
        $command->info(...$arguments);
    }

    #[Test]
    #[TestDox('Call the comment method')]
    public function comment(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['comment'])
            ->getMock();

        $arguments = ['good news'];

        $output->expects($this->once())->method('comment')->with(...$arguments);

        $command = new CommandStub($output);
        $command->comment(...$arguments);
    }

    #[Test]
    #[TestDox('Call the ask method')]
    public function ask(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['ask'])
            ->getMock();

        $arguments = ['how are you?', 'ok', null];

        $output->expects($this->once())->method('ask')->with(...$arguments);

        $command = new CommandStub($output);
        $command->ask(...$arguments);
    }

    #[Test]
    #[TestDox('Call the choice method')]
    public function choice(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['choice'])
            ->getMock();

        $arguments = ['what do you wish?', ['cake', 'beer'], 'beer', true];

        $output->expects($this->once())->method('choice')->with(...$arguments);

        $command = new CommandStub($output);
        $command->choice(...$arguments);
    }

    #[Test]
    #[TestDox('Call the confirm method')]
    public function confirm(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['confirm'])
            ->getMock();

        $arguments = ['really?', true];

        $output->expects($this->once())->method('confirm')->with(...$arguments);

        $command = new CommandStub($output);
        $command->confirm(...$arguments);
    }
}
