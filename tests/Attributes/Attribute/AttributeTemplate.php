<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute;

use Cross\Attributes\Attribute\Attribute;
use Exception;
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
        throw new Exception('Before using this method you must add logic here');
    }
}
