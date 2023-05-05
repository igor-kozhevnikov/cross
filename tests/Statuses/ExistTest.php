<?php

declare(strict_types=1);

namespace Tests\Statuses;

use Cross\Statuses\Exist;
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
    #[TestDox('Checking a value is success')]
    public function success(): void
    {
        $exit = Exist::Success;

        $this->assertTrue($exit->isSuccess());
        $this->assertFalse($exit->isNotSuccess());
    }

    #[Test]
    #[TestDox('Checking a value is equal success')]
    public function equalSuccess(): void
    {
        $this->assertTrue(Exist::isEqualSuccess(0));
        $this->assertTrue(Exist::isEqualSuccess(Exist::Success));
    }

    #[Test]
    #[TestDox('Checking a value is not equal success')]
    public function notEqualSuccess(): void
    {
        $this->assertTrue(Exist::isNotEqualSuccess(1));
        $this->assertTrue(Exist::isNotEqualSuccess(Exist::Invalid));
    }
}
