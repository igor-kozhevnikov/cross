<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Templates\Commands\Attributes\Attribute\Argument\ArgumentTemplate;
use Templates\Commands\Attributes\Attribute\Option\OptionTemplate;

#[CoversClass(Attributes::class)]
final class AttributesTest extends TestCase
{
    #[Test]
    #[TestDox('Initializing attributes')]
    public function constructor(): void
    {
        $argument = new ArgumentTemplate();
        $option = new OptionTemplate();

        $set = [$argument->getName() => $argument, $option->getName() => $option];

        $attributes = new Attributes($set);

        $this->assertSame($set, $attributes->getAll());
    }

    #[Test]
    #[TestDox('Making an instance')]
    public function make(): void
    {
        $attributes = Attributes::make();

        $this->assertInstanceOf(AttributesInterface::class, $attributes);
    }

    #[Test]
    #[TestDox('Defining attributes')]
    public function set(): void
    {
        $argument = new ArgumentTemplate();
        $option = new OptionTemplate();

        $set = [$argument->getName() => $argument, $option->getName() => $option];

        $attributes = new Attributes();
        $attributes->set($set);

        $this->assertSame($set, $attributes->getAll());
    }

    #[Test]
    #[TestDox('Adding an attribute')]
    public function add(): void
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
    #[TestDox('Resetting attributes')]
    public function reset(): void
    {
        $attributes = new Attributes();
        $attributes->set([new ArgumentTemplate(), new OptionTemplate()]);

        $this->assertCount(2, $attributes->getAll());

        $attributes->reset();

        $this->assertEmpty($attributes->getAll());
    }

    #[Test]
    #[TestDox('Merging attributes')]
    public function merge(): void
    {
        $first = new Attributes([new ArgumentTemplate(), new OptionTemplate()]);
        $second = new Attributes([new ArgumentTemplate(), new OptionTemplate()]);

        $merged = array_merge($first->getAll(), $second->getAll());

        $first->merge($second);

        $this->assertSame($merged, $first->getAll());
    }

    #[Test]
    #[TestDox('Returning attributes')]
    public function attributes(): void
    {
        $attributes = new Attributes();

        $this->assertInstanceOf(AttributesInterface::class, $attributes->getAttributes());
    }
}
