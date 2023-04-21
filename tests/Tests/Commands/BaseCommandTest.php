<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\BaseCommand;
use Cross\Commands\Messages\Messages;
use Cross\Commands\Statuses\Prepare;
use Cross\Tests\Stubs\Commands\BaseCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreMethodForCodeCoverage;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
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

        $attributes = Attributes::make()
            ->argument('file')->default('php')->end()
            ->option('silence')->required()->default('true')->end();

        $command = new BaseCommandStub();
        $command->attributes = $attributes;
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

        $command = new BaseCommandStub();
        $command->messages = Messages::make('Good for you!');
        $command->run($input, $output);

        $this->assertTrue(true);
    }

    #[Test]
    #[TestDox('Showing a error message')]
    public function messageError(): void
    {
        $input = new ArrayInput([]);
        $output = new SymfonyStyle($input, new BufferedOutput());

        $command = new BaseCommandStub();
        $command->messages = Messages::make(error: 'Oh, poor boy!');
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
