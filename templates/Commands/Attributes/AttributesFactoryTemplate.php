<?php

declare(strict_types=1);

namespace Templates\Commands\Attributes;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\Attributes\AttributesFactory;
use Cross\Commands\Attributes\AttributesInterface;

class AttributesFactoryTemplate
{
    use AttributesFactory;

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
