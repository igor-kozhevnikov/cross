<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\InitialCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tests\TestCase;

#[CoversClass(InitialCommand::class)]
final class InitialCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the $input and $output properties via the initialize() method')]
    public function initialize(): void
    {
        $input = new ArrayInput([]);
        $output = new ConsoleOutput();

        $command = new InitialCommandTemplate();
        $command->initialize($input, $output);

        $this->assertSame($input, $command->input());
        $this->assertInstanceOf(SymfonyStyle::class, $command->output());
    }

    #[Test]
    #[TestDox('Displaying error messages')]
    public function errors(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['block'])
            ->getMock();

        $output->expects($this->once())->method('block');

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->errors(['To long!', 'To far!']);
    }

    #[Test]
    #[TestDox('Displaying an error message')]
    public function error(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['block'])
            ->getMock();

        $output->expects($this->exactly(2))->method('block');

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->error('To long!', 'Actually 500ms.');
    }

    #[Test]
    #[TestDox('Displaying a success message')]
    public function success(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['success'])
            ->getMock();

        $output->expects($this->once())->method('success');

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->success('Way to go!');
    }

    #[Test]
    #[TestDox('Getting arguments via the arguments() method')]
    public function arguments(): void
    {
        $command = new InitialCommandTemplate();
        $command->addArgument('counter', default: 10);
        $command->run();

        $this->assertSame(['counter' => 10], $command->arguments());
    }

    #[Test]
    #[TestDox('Getting an argument via the argument() method')]
    public function argument(): void
    {
        $command = new InitialCommandTemplate();
        $command->addArgument('counter', default: 10);
        $command->run();

        $this->assertSame(10, $command->argument('counter'));
        $this->assertSame(null, $command->argument('undefined'));
    }

    #[Test]
    #[TestDox('Getting options via the options() method')]
    public function options(): void
    {
        $command = new InitialCommandTemplate();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(['counter' => 10], $command->options());
    }

    #[Test]
    #[TestDox('Getting an option via the option() method')]
    public function option(): void
    {
        $command = new InitialCommandTemplate();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(10, $command->option('counter'));
        $this->assertSame(null, $command->option('undefined'));
    }

    #[Test]
    #[TestDox('Getting a value depending on whether an option exists')]
    public function whenOption(): void
    {
        $command = new InitialCommandTemplate();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(true, $command->whenOption('counter', true, false));
        $this->assertSame(false, $command->whenOption('undefined', true, false));
    }

    #[Test]
    #[TestDox('Getting a value depending on whether an option does not exist')]
    public function whenNotOption(): void
    {
        $command = new InitialCommandTemplate();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(false, $command->whenNotOption('counter', true, false));
        $this->assertSame(true, $command->whenNotOption('undefined', true, false));
    }

    #[Test]
    #[TestDox('Executing the info() method of the base command')]
    public function info(): void
    {
        $arguments = ['No smoking!'];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['info'])
            ->getMock();

        $output->expects($this->once())->method('info')->with(...$arguments);

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->info(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the comment() method of the base command')]
    public function comment(): void
    {
        $arguments = ['Remember that moment!'];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['comment'])
            ->getMock();

        $output->expects($this->once())->method('comment')->with(...$arguments);

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->comment(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the ask() method of the base command')]
    public function ask(): void
    {
        $arguments = ['Whats up?', 'No bad', null];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['ask'])
            ->getMock();

        $output->expects($this->once())->method('ask')->with(...$arguments);

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->ask(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the choice() method of the base command')]
    public function choice(): void
    {
        $arguments = ['What would you like?', ['cake', 'beer'], 'beer', true];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['choice'])
            ->getMock();

        $output->expects($this->once())->method('choice')->with(...$arguments);

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->choice(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the confirm() method of the base command')]
    public function confirm(): void
    {
        $arguments = ['Really?', true];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['confirm'])
            ->getMock();

        $output->expects($this->once())->method('confirm')->with(...$arguments);

        $command = new InitialCommandTemplate();
        $command->output = $output;
        $command->confirm(...$arguments);
    }
}
