<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\Sequence\Sequence;
use Cross\Commands\Sequence\SequenceItem;
use Cross\Commands\SequenceCommand;
use Cross\Commands\Statuses\Exist;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Application;
use Templates\Commands\BaseCommandTemplate;
use Templates\Commands\InitialCommandTemplate;
use Templates\Commands\SequenceCommandTemplate;
use Tests\TestCase;

#[CoversClass(SequenceCommand::class)]
final class SequenceCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Successful handling a sequence')]
    public function handleSuccessful(): void
    {
        $firstCommand = new InitialCommandTemplate();
        $secondCommand = new InitialCommandTemplate();

        $firstSequenceItem = new SequenceItem($firstCommand->getName());
        $secondSequenceItem = new SequenceItem($secondCommand->getName());

        $application = new Application();
        $application->add($firstCommand);
        $application->add($secondCommand);

        $sequence = new Sequence();
        $sequence->add($firstSequenceItem);
        $sequence->add($secondSequenceItem);

        $command = new SequenceCommandTemplate();
        $command->sequence = $sequence;
        $command->initialize();
        $command->setApplication($application);

        $this->assertSame(Exist::Success, $command->handle());
    }

    #[Test]
    #[TestDox('Unsuccessful handling a sequence')]
    public function handleUnsuccessful(): void
    {
        $command = new BaseCommandTemplate();
        $command->handle = Exist::Failure;

        $sequenceItem = new SequenceItem($command->getName());

        $sequence = new Sequence();
        $sequence->add($sequenceItem);

        $application = new Application();
        $application->add($command);

        $command = new SequenceCommandTemplate();
        $command->sequence = $sequence;
        $command->initialize();
        $command->setApplication($application);

        $this->assertSame(Exist::Failure, $command->handle());
    }
}
