<?php

declare(strict_types=1);

namespace Tests\Statuses;

use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Prepare::class)]
final class PrepareTest extends TestCase
{
    #[Test]
    #[TestDox('Correct exist code values')]
    public function exist(): void
    {
        $this->assertSame(Exist::Success, Prepare::Continue->toExist());
        $this->assertSame(Exist::Failure, Prepare::Stop->toExist());
        $this->assertSame(Exist::Success, Prepare::Skip->toExist());
    }

    #[Test]
    #[TestDox('Determinate a not continue value')]
    public function notContinue(): void
    {
        $this->assertTrue(Prepare::Stop->isNotContinue());
        $this->assertTrue(Prepare::Skip->isNotContinue());
    }
}
