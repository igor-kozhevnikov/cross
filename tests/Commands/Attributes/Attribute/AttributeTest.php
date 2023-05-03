<?php

declare(strict_types=1);

namespace Tests\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Attribute;
use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Completion\Suggestion;
use Templates\Commands\Attributes\ArgumentTemplate;
use Templates\Commands\Attributes\OptionTemplate;
use Tests\TestCase;

#[CoversClass(Attribute::class)]
final class AttributeTest extends TestCase
{
    #[Test]
    #[TestDox('Defining a name via a setter')]
    public function nameViaSetter(): void
    {
        $name = 'title';

        $attribute = new ArgumentTemplate();
        $attribute->setName($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining a name via a fluent method')]
    public function nameViaFluent(): void
    {
        $name = 'title';

        $attribute = new ArgumentTemplate();
        $attribute->name($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining a description via a setter')]
    public function descriptionViaSetter(): void
    {
        $description = 'Rapid walking';

        $attribute = new OptionTemplate();
        $attribute->setDescription($description);

        $this->assertSame($description, $attribute->getDescription());
    }

    #[Test]
    #[TestDox('Defining a description via a fluent method')]
    public function descriptionViaFluent(): void
    {
        $description = 'Rapid walking';

        $attribute = new OptionTemplate();
        $attribute->description($description);

        $this->assertSame($description, $attribute->getDescription());
    }

    #[Test]
    #[TestDox('Defining a mode via a setter')]
    public function modeViaSetter(): void
    {
        $mode = 10;

        $attribute = new OptionTemplate();
        $attribute->setMode($mode);

        $this->assertSame($mode, $attribute->getMode());
    }

    #[Test]
    #[TestDox('Defining a mode via a fluent method')]
    public function modeViaFluent(): void
    {
        $mode = 10;

        $attribute = new OptionTemplate();
        $attribute->mode($mode);

        $this->assertSame($mode, $attribute->getMode());
    }

    #[Test]
    #[TestDox('Defining a default value via a setter')]
    public function defaultViaSetter(): void
    {
        $default = 10.5;

        $attribute = new ArgumentTemplate();
        $attribute->setDefault($default);

        $this->assertSame($default, $attribute->getDefault());
    }

    #[Test]
    #[TestDox('Defining a default value via a fluent method')]
    public function defaultViaFluent(): void
    {
        $default = 10.5;

        $attribute = new ArgumentTemplate();
        $attribute->default($default);

        $this->assertSame($default, $attribute->getDefault());
    }

    #[Test]
    #[TestDox('Defining suggestions via a setter')]
    public function suggestionsViaSetter(): void
    {
        $suggestions = [new Suggestion('10')];

        $attribute = new OptionTemplate();
        $attribute->setSuggestions($suggestions);

        $this->assertSame($suggestions, $attribute->getSuggestions());
    }

    #[Test]
    #[TestDox('Defining suggestions via a fluent method')]
    public function suggestionsViaFluent(): void
    {
        $suggestions = [new Suggestion('10')];

        $attribute = new OptionTemplate();
        $attribute->setSuggestions($suggestions);

        $this->assertSame($suggestions, $attribute->getSuggestions());
    }

    #[Test]
    #[TestDox('Adding an attribute to container')]
    public function end(): void
    {
        $attribute = new OptionTemplate();
        $attribute->setAttributes(new Attributes());

        $this->assertInstanceOf(AttributesInterface::class, $attribute->end());
    }
}