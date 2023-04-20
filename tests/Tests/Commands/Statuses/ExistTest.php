<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Statuses;

use Cross\Commands\Statuses\Exist;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Exist::class)]
final class ExistTest extends TestCase
{
    #[Test]
    #[TestDox('Correct values')]
    public function values(): void
    {
        $this->assertSame(0, Exist::Success->value);
        $this->assertSame(1, Exist::Failure->value);
        $this->assertSame(2, Exist::Invalid->value);
    }

    #[Test]
    #[TestDox('Determinate a success value')]
    public function success(): void
    {
        $this->assertTrue(Exist::isSuccess(0));
        $this->assertTrue(Exist::isSuccess(Exist::Success));
    }

    #[Test]
    #[TestDox('Determinate a not success value')]
    public function notSuccess(): void
    {
        $this->assertTrue(Exist::isNotSuccess(1));
        $this->assertTrue(Exist::isNotSuccess(Exist::Invalid));
    }
}
