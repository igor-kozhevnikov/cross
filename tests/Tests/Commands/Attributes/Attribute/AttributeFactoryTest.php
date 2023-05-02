<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Argument\Argument;
use Cross\Commands\Attributes\Attribute\AttributeFactory;
use Cross\Commands\Attributes\Attribute\Option\Option;
use Cross\Commands\Attributes\Attributes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeFactory::class)]
final class AttributeFactoryTest extends TestCase
{
    #[Test]
    #[TestDox('Making an argument')]
    public function argument(): void
    {
        $argument = (new Attributes())->argument('timeout');

        $this->assertInstanceOf(Argument::class, $argument);
    }

    #[Test]
    #[TestDox('Making an option')]
    public function option(): void
    {
        $option = (new Attributes())->option('timeout');

        $this->assertInstanceOf(Option::class, $option);
    }
}
