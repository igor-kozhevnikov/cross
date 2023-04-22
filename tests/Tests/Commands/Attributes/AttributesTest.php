<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes;

use Cross\Commands\Attributes\Attributes;
use Cross\Tests\Stubs\Commands\Attrubutes\Attribute\Argument\ArgumentStub;
use Cross\Tests\Stubs\Commands\Attrubutes\Attribute\Option\OptionStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(Attributes::class)]
final class AttributesTest extends TestCase
{
    #[Test]
    #[TestDox('Initializing attributes')]
    public function constructor(): void
    {
        $argument = new ArgumentStub();
        $option = new OptionStub();

        $set = [$argument->getName() => $argument, $option->getName() => $option];

        $attributes = new Attributes($set);

        $this->assertSame($set, $attributes->all());
    }

    #[Test]
    #[TestDox('Defining attributes')]
    public function set(): void
    {
        $argument = new ArgumentStub();
        $option = new OptionStub();

        $set = [$argument->getName() => $argument, $option->getName() => $option];

        $attributes = new Attributes();
        $attributes->set($set);

        $this->assertSame($set, $attributes->all());
    }

    #[Test]
    #[TestDox('Adding an attribute')]
    public function add(): void
    {
        $argument = new ArgumentStub();
        $option = new OptionStub();

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
        $attributes->set([new ArgumentStub(),  new OptionStub()]);

        $this->assertCount(2, $attributes->all());

        $attributes->reset();

        $this->assertEmpty($attributes->all());
    }

    #[Test]
    #[TestDox('Merging attributes')]
    public function merge(): void
    {
        $first = new Attributes([new ArgumentStub(),  new OptionStub()]);
        $second  = new Attributes([new ArgumentStub(),  new OptionStub()]);

        $merged = array_merge($first->all(), $second->all());

        $first->merge($second);

        $this->assertSame($merged, $first->all());
    }

    #[Test]
    #[TestDox('Iteration attributes')]
    public function iterator(): void
    {
        $attributes = new Attributes();

        $this->assertIsIterable($attributes);
        $this->assertIsIterable($attributes->getIterator());
    }
}
