<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\AttributeFactory;
use Cross\Commands\Attributes\Attributes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Templates\Commands\Attributes\ArgumentTemplate;
use Templates\Commands\Attributes\OptionTemplate;

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

        $this->assertSame($set, $attributes->all());
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

        $this->assertSame($set, $attributes->all());
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

        $this->assertCount(2, $attributes->all());

        $attributes->reset();

        $this->assertEmpty($attributes->all());
    }

    #[Test]
    #[TestDox('Merging attributes')]
    public function merge(): void
    {
        $first = new Attributes([new ArgumentTemplate(), new OptionTemplate()]);
        $second = new Attributes([new ArgumentTemplate(), new OptionTemplate()]);

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

    #[Test]
    #[TestDox('Returning a factory')]
    public function factory(): void
    {
        $attributes = new Attributes();

        $this->assertInstanceOf(AttributeFactory::class, $attributes->getFluentFactory());
    }
}
