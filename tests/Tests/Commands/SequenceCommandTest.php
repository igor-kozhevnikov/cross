<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Sequence\Sequence;
use Cross\Commands\SequenceCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Commands\BaseCommandStub;
use Cross\Tests\Stubs\Commands\Sequence\ItemStub;
use Cross\Tests\Stubs\Commands\SequenceCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

#[CoversClass(SequenceCommand::class)]
final class SequenceCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Successful handling a sequence')]
    public function handleSuccessful(): void
    {
        $item = new ItemStub();

        $command = new BaseCommandStub();
        $command->name = $item->getName();
        $command->configure();

        $application = new Application();
        $application->add($command);

        $sequence = new SequenceCommandStub();
        $sequence->input = new ArrayInput([]);
        $sequence->output = new SymfonyStyle($sequence->input, new BufferedOutput());
        $sequence->setApplication($application);
        $sequence->sequence = new Sequence([$item]);

        $this->assertSame(Exist::Success, $sequence->handle());
    }

    #[Test]
    #[TestDox('Unsuccessful handling a sequence')]
    public function handleUnsuccessful(): void
    {
        $item = new ItemStub();

        $command = new BaseCommandStub();
        $command->name = $item->getName();
        $command->exist = Exist::Failure;
        $command->configure();

        $application = new Application();
        $application->add($command);

        $sequence = new SequenceCommandStub();
        $sequence->input = new ArrayInput([]);
        $sequence->output = new SymfonyStyle($sequence->input, new BufferedOutput());
        $sequence->setApplication($application);
        $sequence->sequence = new Sequence([$item]);

        $this->assertSame(Exist::Failure, $sequence->handle());
    }
}
