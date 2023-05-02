<?php

declare(strict_types=1);

namespace Cross\Tests\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Attribute;
use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Completion\Suggestion;

#[CoversClass(Attribute::class)]
final class AttributeTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a name via a setter')]
    public function nameViaSetter(): void
    {
        $name = 'timeout';

        $attribute = new AttributeStub();
        $attribute->setName($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining a name via a fluent method')]
    public function nameViaFluent(): void
    {
        $name = 'timeout';

        $attribute = new AttributeStub();
        $attribute->name($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining a description via a setter')]
    public function descriptionViaSetter(): void
    {
        $description = 'Rapid walking';

        $option = new AttributeStub();
        $option->setDescription($description);

        $this->assertSame($description, $option->getDescription());
    }

    #[Test]
    #[TestDox('Defining a description via a fluent method')]
    public function descriptionViaFluent(): void
    {
        $description = 'Rapid walking';

        $option = new AttributeStub();
        $option->description($description);

        $this->assertSame($description, $option->getDescription());
    }

    #[Test]
    #[TestDox('Defining a mode via a setter')]
    public function modeViaSetter(): void
    {
        $mode = 10;

        $attribute = new AttributeStub();
        $attribute->setMode($mode);

        $this->assertSame($mode, $attribute->getMode());
    }

    #[Test]
    #[TestDox('Defining a mode via a fluent method')]
    public function modeViaFluent(): void
    {
        $mode = 10;

        $attribute = new AttributeStub();
        $attribute->mode($mode);

        $this->assertSame($mode, $attribute->getMode());
    }

    #[Test]
    #[TestDox('Defining a default value via a setter')]
    public function defaultViaSetter(): void
    {
        $default = 10.5;

        $attribute = new AttributeStub();
        $attribute->setDefault($default);

        $this->assertSame($default, $attribute->getDefault());
    }

    #[Test]
    #[TestDox('Defining a default value via a fluent method')]
    public function defaultViaFluent(): void
    {
        $default = 10.5;

        $attribute = new AttributeStub();
        $attribute->default($default);

        $this->assertSame($default, $attribute->getDefault());
    }

    #[Test]
    #[TestDox('Defining suggestions via a setter')]
    public function suggestionsViaSetter(): void
    {
        $suggestions = [new Suggestion('10')];

        $attribute = new AttributeStub();
        $attribute->setSuggestions($suggestions);

        $this->assertSame($suggestions, $attribute->getSuggestions());
    }

    #[Test]
    #[TestDox('Defining suggestions via a fluent method')]
    public function suggestionsViaFluent(): void
    {
        $suggestions = [new Suggestion('10')];

        $attribute = new AttributeStub();
        $attribute->setSuggestions($suggestions);

        $this->assertSame($suggestions, $attribute->getSuggestions());
    }

    #[Test]
    #[TestDox('Adding an attribute to container')]
    public function end(): void
    {
        $attribute = new AttributeStub();
        $attribute->setAttributes(new Attributes());

        $attributes = $attribute->name('over')->end();

        $this->assertInstanceOf(AttributesInterface::class, $attributes);
    }
}
