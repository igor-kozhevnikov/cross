<?php

declare(strict_types=1);

namespace Tests\Attributes;

use Cross\Attributes\Attributes;
use Cross\Attributes\AttributesInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Attributes\Attribute\Argument\ArgumentTemplate;
use Tests\Attributes\Attribute\Option\OptionTemplate;

#[CoversClass(Attributes::class)]
final class AttributesTest extends TestCase
{
    #[Test]
    #[TestDox('Making an instance via make() method')]
    public function make(): void
    {
        $attributes = Attributes::make();

        $this->assertInstanceOf(AttributesInterface::class, $attributes);
    }

    #[Test]
    #[TestDox('Defining the $attributes property via the constructor')]
    public function attributesViaConstructor(): void
    {
        $argument = new ArgumentTemplate();
        $option = new OptionTemplate();
        $set = [$argument->getName() => $argument, $option->getName() => $option];
        $attributes = new Attributes($set);

        $this->assertSame($set, $attributes->getAll());
    }

    #[Test]
    #[TestDox('Defining the $attributes property via the setter')]
    public function attributesViaSetter(): void
    {
        $argument = new ArgumentTemplate();
        $option = new OptionTemplate();
        $set = [$argument->getName() => $argument, $option->getName() => $option];

        $attributes = new Attributes();
        $attributes->set($set);

        $this->assertSame($set, $attributes->getAll());
    }

    #[Test]
    #[TestDox('Adding an attribute via the add() method')]
    public function attributesViaAdd(): void
    {
        $argument = new ArgumentTemplate();
        $option = new OptionTemplate();

        $attributes = new Attributes();
        $attributes->add($argument);
        $attributes->add($option);

        $this->assertSame($argument, $attributes->get($argument->getName()));
        $this->assertSame($option, $attributes->get($option->getName()));
    }

    #[Test]
    #[TestDox('Resetting attributes via the reset() method')]
    public function reset(): void
    {
        $attributes = new Attributes([new ArgumentTemplate(), new OptionTemplate()]);
        $attributes->reset();

        $this->assertEmpty($attributes->getAll());
    }

    #[Test]
    #[TestDox('Returning a self instance from the getAttributes() method')]
    public function attributes(): void
    {
        $attributes = new Attributes();

        $this->assertInstanceOf(AttributesInterface::class, $attributes->getAttributes());
    }
}
