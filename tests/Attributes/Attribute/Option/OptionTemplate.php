<?php

declare(strict_types=1);

namespace Tests\Attributes\Attribute\Option;

use Closure;
use Cross\Attributes\Attribute\Option\Option;

class OptionTemplate extends Option
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
    public function getFluentAlias(string $name): ?Closure
    {
        return parent::getFluentAlias($name);
    }
}
