<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\Argument\ArgumentInterface;
use Cross\Commands\Attributes\Attribute\Option\OptionInterface;
use Cross\Commands\Attributes\AttributesFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Templates\Commands\Attributes\AttributesFactoryTemplate;

#[CoversClass(AttributesFactory::class)]
final class AttributesFactoryTest extends TestCase
{
    #[Test]
    #[TestDox('Creating an argument')]
    public function argument(): void
    {
        $factory = new AttributesFactoryTemplate();
        $argument = $factory->argument('name');

        $this->assertInstanceOf(ArgumentInterface::class, $argument);
        $this->assertContains($argument, $factory->getAttributes()->getAll());
    }

    #[Test]
    #[TestDox('Creating an option')]
    public function option(): void
    {
        $factory = new AttributesFactoryTemplate();
        $option = $factory->option('--fast');

        $this->assertInstanceOf(OptionInterface::class, $option);
        $this->assertContains($option, $factory->getAttributes()->getAll());
    }
}
