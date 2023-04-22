<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Commands\Attributes\Attributes;
use Cross\Commands\BaseCommand;
use Cross\Commands\Messages\Messages;
use Cross\Commands\Statuses\Prepare;
use Cross\Tests\Stubs\Commands\BaseCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

#[CoversClass(BaseCommand::class)]
final class BaseCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Defining simple properties')]
    public function properties(): void
    {
        $command = new BaseCommandStub();
        $command->name = 'elephant';
        $command->description = 'a big animal';
        $command->aliases = ['mammoth'];
        $command->hidden = true;
        $command->configure();

        $this->assertSame($command->name, $command->getName());
        $this->assertSame($command->name, $command->name());

        $this->assertSame($command->description, $command->getDescription());
        $this->assertSame($command->description, $command->description());

        $this->assertSame($command->aliases, $command->getAliases());
        $this->assertSame($command->aliases, $command->aliases());

        $this->assertSame($command->hidden, $command->isHidden());
        $this->assertSame($command->hidden, $command->hidden());
    }

    #[Test]
    #[TestDox('Defining attributes')]
    public function attributes(): void
    {
        $input = new ArrayInput([]);
        $output = new SymfonyStyle($input, new BufferedOutput());

        $argument = new Argument('file');
        $argument->setDefault('php');

        $option = new Option('silence');
        $option->setMode(InputOption::VALUE_REQUIRED);
        $option->setDefault('true');

        $command = new BaseCommandStub();
        $command->attributes = new Attributes([$argument, $option]);
        $command->configure();
        $command->run($input, $output);

        $this->assertIsIterable($command->arguments());
        $this->assertIsIterable($command->options());
        $this->assertSame('php', $command->argument('file'));
        $this->assertSame('true', $command->option('silence'));
    }

    #[Test]
    #[TestDox('Showing a success message')]
    public function messageSuccess(): void
    {
        $input = new ArrayInput([]);
        $output = new SymfonyStyle($input, new BufferedOutput());

        $messages = new Messages();
        $messages->setSuccess('Good for you!');

        $command = new BaseCommandStub();
        $command->messages = $messages;
        $command->run($input, $output);

        $this->assertTrue(true);
    }

    #[Test]
    #[TestDox('Showing a error message')]
    public function messageError(): void
    {
        $input = new ArrayInput([]);
        $output = new SymfonyStyle($input, new BufferedOutput());

        $messages = new Messages();
        $messages->setError('Oh, poor boy!');

        $command = new BaseCommandStub();
        $command->messages = $messages;
        $command->run($input, $output);

        $this->assertTrue(true);
    }

    #[Test]
    #[TestDox('Defining a prepare code')]
    public function prepare(): void
    {
        $command = new BaseCommandStub();
        $command->prepare = Prepare::Continue;

        $this->assertSame(Prepare::Continue, $command->prepare());
    }

    #[Test]
    #[TestDox('Executing the execute() method with the stop prepare status')]
    public function executePrepareStop(): void
    {
        $input = new ArrayInput([]);
        $output = new BufferedOutput();

        $command = new BaseCommandStub();
        $command->prepare = Prepare::Stop;

        $exist = $command->execute($input, $output);

        $this->assertSame(Prepare::Stop->exist(), $exist);
    }

    #[Test]
    #[TestDox('Executing the execute() with the skip prepare status')]
    public function executePrepareSkip(): void
    {
        $input = new ArrayInput([]);
        $output = new BufferedOutput();

        $command = new BaseCommandStub();
        $command->prepare = Prepare::Skip;

        $exist = $command->execute($input, $output);

        $this->assertSame(Prepare::Skip->exist(), $exist);
    }
}
