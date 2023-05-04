<?php

declare(strict_types=1);

namespace Templates\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\AttributeFactory;
use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesInterface;

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
