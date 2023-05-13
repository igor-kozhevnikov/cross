<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute;

use Cross\Attributes\Attribute\Attribute;
use Cross\Attributes\Attributes;
use Cross\Attributes\AttributesInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Component\Console\Completion\Suggestion;
use Tests\TestCase;

#[CoversClass(Attribute::class)]
final class AttributeTest extends TestCase
{
    #[Test]
    #[TestDox('Defining the $name property via the setter')]
    public function nameViaSetter(): void
    {
        $name = 'title';

        $attribute = new AttributeTemplate();
        $attribute->setName($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining the $name property via the fluent setter')]
    public function nameViaFluentSetter(): void
    {
        $name = 'description';

        $attribute = new AttributeTemplate();
        $attribute->name($name);

        $this->assertSame($name, $attribute->getName());
    }

    #[Test]
    #[TestDox('Defining the $description property via the setter')]
    public function descriptionViaSetter(): void
    {
        $description = 'Rapid walking';

        $attribute = new AttributeTemplate();
        $attribute->setDescription($description);

        $this->assertSame($description, $attribute->getDescription());
    }

    #[Test]
    #[TestDox('Defining the $description property via the fluent setter')]
    public function descriptionViaFluentSetter(): void
    {
        $description = 'Slow walking';

        $attribute = new AttributeTemplate();
        $attribute->description($description);

        $this->assertSame($description, $attribute->getDescription());
    }

    #[Test]
    #[TestDox('Defining the $mode property via the setter')]
    public function modeViaSetter(): void
    {
        $mode = 10;

        $attribute = new AttributeTemplate();
        $attribute->setMode($mode);

        $this->assertSame($mode, $attribute->getMode());
    }

    #[Test]
    #[TestDox('Defining the $mode property via the fluent setter')]
    public function modeViaFluentSetter(): void
    {
        $mode = 20;

        $attribute = new AttributeTemplate();
        $attribute->mode($mode);

        $this->assertSame($mode, $attribute->getMode());
    }

    #[Test]
    #[TestDox('Defining the $default property via the setter')]
    public function defaultViaSetter(): void
    {
        $default = 10.5;

        $attribute = new AttributeTemplate();
        $attribute->setDefault($default);

        $this->assertSame($default, $attribute->getDefault());
    }

    #[Test]
    #[TestDox('Defining the $default property via the fluent setter')]
    public function defaultViaFluentSetter(): void
    {
        $default = 0.5;

        $attribute = new AttributeTemplate();
        $attribute->default($default);

        $this->assertSame($default, $attribute->getDefault());
    }

    #[Test]
    #[TestDox('Defining the $suggestions property via the setter')]
    public function suggestionsViaSetter(): void
    {
        $suggestions = [new Suggestion('10')];

        $attribute = new AttributeTemplate();
        $attribute->setSuggestions($suggestions);

        $this->assertSame($suggestions, $attribute->getSuggestions());
    }

    #[Test]
    #[TestDox('Defining the $suggestions property via the fluent setter')]
    public function suggestionsViaFluentSetter(): void
    {
        $suggestions = [new Suggestion('15')];

        $attribute = new AttributeTemplate();
        $attribute->suggestions($suggestions);

        $this->assertSame($suggestions, $attribute->getSuggestions());
    }

    #[Test]
    #[TestDox('Defining the $attributes property via the setter')]
    public function attributesViaSetter(): void
    {
        $attribute = new AttributeTemplate();
        $attribute->setAttributes(new Attributes());

        $this->assertInstanceOf(AttributesInterface::class, $attribute->getAttributes());
    }
}
