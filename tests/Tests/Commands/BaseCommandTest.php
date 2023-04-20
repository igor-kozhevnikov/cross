<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\BaseCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Commands\Statuses\Prepare;
use Cross\Tests\Stubs\Commands\BaseCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

#[CoversClass(BaseCommand::class)]
final class BaseCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Define properties')]
    public function properties(): void
    {
        $command = new BaseCommandStub('elephant', 'a big animal', ['mammoth'], true);

        $this->assertSame($command->name, $command->getName());
        $this->assertSame($command->description, $command->getDescription());
        $this->assertSame($command->aliases, $command->getAliases());
        $this->assertSame($command->hidden, $command->isHidden());
    }

    #[Test]
    #[TestDox('Define attributes')]
    public function attributes(): void
    {
        $attributes = Attributes::make()
            ->argument('file')->default('php')->end()
            ->option('silence')->required()->default('true')->end();

        $command = new BaseCommandStub(attributes: $attributes);
        $command->call();

        $this->assertSame('php', $command->argument('file'));
        $this->assertSame('true', $command->option('silence'));
    }

    #[Test]
    #[TestDox('Return prepare code')]
    public function prepare(): void
    {
        $command = new BaseCommandStub(prepare: Prepare::Continue);

        $this->assertSame(Prepare::Continue, $command->prepare());
    }

    #[Test]
    #[TestDox('Run execute() with the stop prepare status')]
    public function executePrepareStop(): void
    {
        $input = new ArrayInput([]);
        $output = new BufferedOutput();

        $command = new BaseCommandStub(prepare: Prepare::Stop);
        $exist = $command->execute($input, $output);

        $this->assertSame(Prepare::Stop->exist(), $exist);
    }

    #[Test]
    #[TestDox('Run execute() with the skip prepare status')]
    public function executePrepareSkip(): void
    {
        $input = new ArrayInput([]);
        $output = new BufferedOutput();

        $command = new BaseCommandStub(prepare: Prepare::Skip);
        $exist = $command->execute($input, $output);

        $this->assertSame(Prepare::Skip->exist(), $exist);
    }
}
