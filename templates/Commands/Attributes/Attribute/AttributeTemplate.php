<?php

declare(strict_types=1);

namespace Templates\Commands\Attributes\Attribute;

use Cross\Commands\Attributes\Attribute\Attribute;
use Symfony\Component\Console\Command\Command;

class AttributeTemplate extends Attribute
{
    /**
     * @inheritDoc
     */
    public function __construct(string $name = null)
    {
        parent::__construct($this->name = $name ?: (string) rand());
    }

    /**
     * @inheritDoc
     */
    public function appendTo(Command $command): void
    {
        //
    }
}
