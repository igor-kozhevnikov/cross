<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute;

use Cross\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Attributes\Attribute\AttributeFactory;
use Cross\Attributes\Attribute\Option\OptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeFactory::class)]
final class AttributeFactoryTest extends TestCase
{
    #[Test]
    #[TestDox('Creating an argument')]
    public function argument(): void
    {
        $factory = new AttributeFactoryTemplate();
        $argument = $factory->argument('name');

        $this->assertInstanceOf(ArgumentInterface::class, $argument);
        $this->assertContains($argument, $factory->getAttributes()->getAll());
    }

    #[Test]
    #[TestDox('Creating an option')]
    public function option(): void
    {
        $factory = new AttributeFactoryTemplate();
        $option = $factory->option('--fast');

        $this->assertInstanceOf(OptionInterface::class, $option);
        $this->assertContains($option, $factory->getAttributes()->getAll());
    }
}
