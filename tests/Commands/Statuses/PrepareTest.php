<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Statuses;

use Cross\Commands\Statuses\Prepare;
use Cross\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Prepare::class)]
final class PrepareTest extends TestCase
{
    #[Test]
    #[TestDox('Correct exist code values')]
    public function exist(): void
    {
        $this->assertSame(0, Prepare::Continue->exist());
        $this->assertSame(1, Prepare::Stop->exist());
        $this->assertSame(0, Prepare::Skip->exist());
    }

    #[Test]
    #[TestDox('Determinate a not continue value')]
    public function notContinue(): void
    {
        $this->assertTrue(Prepare::Stop->isNotContinue());
        $this->assertTrue(Prepare::Skip->isNotContinue());
    }
}
