<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\DeputyCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Commands\DeputyCommandStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeputyCommand::class)]
final class DeputyCommandTest extends TestCase
{
    #[Test]
    #[TestDox('Returns properties')]
    public function properties(): void
    {
        $command = new DeputyCommandStub('monkey', ['big' => true]);

        $this->assertSame($command->deputy, $command->deputy());
        $this->assertSame($command->parameters, $command->parameters());
    }

    #[Test]
    #[TestDox('Call the handler method')]
    public function handler(): void
    {
        $command = new DeputyCommandStub();

        $this->assertSame(Exist::Success, $command->handle());
    }
}
