<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute;

use Cross\Attributes\Attribute\AttributeFactory;
use Cross\Attributes\Attributes;
use Cross\Attributes\AttributesInterface;

class AttributeFactoryTemplate
{
    use AttributeFactory;

    /**
     * Attributes.
     */
    protected AttributesInterface $attributes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->attributes = new Attributes();
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(): AttributesInterface
    {
        return $this->attributes;
    }
}
