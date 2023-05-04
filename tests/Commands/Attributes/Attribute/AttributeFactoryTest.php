<?php

declare(strict_types=1);

namespace Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Commands\Attributes\Attribute\AttributeFactory;
use Cross\Commands\Attributes\Attribute\Option\OptionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Templates\Commands\Attributes\Attribute\AttributeFactoryTemplate;

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
