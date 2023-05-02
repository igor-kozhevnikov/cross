<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\InitialCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

#[CoversClass(InitialCommand::class)]
final class InitialCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Initializing an input and output')]
    public function initialize(): void
    {
        $input = new ArrayInput([]);
        $output = new SymfonyStyle($input, new BufferedOutput());

        $command = new InitialCommandStub();
        $command->initialize($input, $output);

        $this->assertSame($input, $command->input);
        $this->assertSame($input, $command->input());

        $this->assertSame($output, $command->output);
        $this->assertSame($output, $command->output());
    }

    #[Test]
    #[TestDox('Outputting error messages')]
    public function errors(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['block'])
            ->getMock();

        $output->expects($this->once())->method('block');

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->errors(['To long!', 'To far!']);
    }

    #[Test]
    #[TestDox('Outputting an error message')]
    public function error(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['block'])
            ->getMock();

        $output->expects($this->exactly(2))->method('block');

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->error('To long!', 'Actually 500ms.');
    }

    #[Test]
    #[TestDox('Outputting a success messages')]
    public function success(): void
    {
        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['success'])
            ->getMock();

        $output->expects($this->once())->method('success');

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->success('Way to go!');
    }

    #[Test]
    #[TestDox('Getting arguments')]
    public function arguments(): void
    {
        $command = new InitialCommandStub();
        $command->addArgument('counter', default: 10);
        $command->run();

        $this->assertSame(['counter' => 10], $command->arguments());
    }

    #[Test]
    #[TestDox('Getting an argument')]
    public function argument(): void
    {
        $command = new InitialCommandStub();
        $command->addArgument('counter', default: 10);
        $command->run();

        $this->assertSame(10, $command->argument('counter'));
        $this->assertSame(null, $command->argument('undefined'));
    }

    #[Test]
    #[TestDox('Getting options')]
    public function options(): void
    {
        $command = new InitialCommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(['counter' => 10], $command->options());
    }

    #[Test]
    #[TestDox('Getting an option')]
    public function option(): void
    {
        $command = new InitialCommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(10, $command->option('counter'));
        $this->assertSame(null, $command->option('undefined'));
    }


    #[Test]
    #[TestDox('Getting a value depend on a positive option')]
    public function whenOption(): void
    {
        $command = new InitialCommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(true, $command->whenOption('counter', true, false));
        $this->assertSame(false, $command->whenOption('undefined', true, false));
    }

    #[Test]
    #[TestDox('Getting a value depend on a negative option')]
    public function whenNotOption(): void
    {
        $command = new InitialCommandStub();
        $command->addOption('counter', mode: InputOption::VALUE_REQUIRED, default: 10);
        $command->run();

        $this->assertSame(false, $command->whenNotOption('counter', true, false));
        $this->assertSame(true, $command->whenNotOption('undefined', true, false));
    }

    #[Test]
    #[TestDox('Executing the info method')]
    public function info(): void
    {
        $arguments = ['No smoking!'];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['info'])
            ->getMock();

        $output->expects($this->once())->method('info')->with(...$arguments);

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->info(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the comment method')]
    public function comment(): void
    {
        $arguments = ['Remember that moment!'];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['comment'])
            ->getMock();

        $output->expects($this->once())->method('comment')->with(...$arguments);

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->comment(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the ask method')]
    public function ask(): void
    {
        $arguments = ['Whats up?', 'No bad', null];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['ask'])
            ->getMock();

        $output->expects($this->once())->method('ask')->with(...$arguments);

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->ask(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the choice method')]
    public function choice(): void
    {
        $arguments = ['What would you like?', ['cake', 'beer'], 'beer', true];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['choice'])
            ->getMock();

        $output->expects($this->once())->method('choice')->with(...$arguments);

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->choice(...$arguments);
    }

    #[Test]
    #[TestDox('Executing the confirm method')]
    public function confirm(): void
    {
        $arguments = ['Really?', true];

        $output = $this->getMockBuilder(SymfonyStyle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['confirm'])
            ->getMock();

        $output->expects($this->once())->method('confirm')->with(...$arguments);

        $command = new InitialCommandStub();
        $command->output = $output;
        $command->confirm(...$arguments);
    }
}
