<?php

declare(strict_types=1);

namespace Templates\Commands\Attributes;

use Cross\Commands\Attributes\Attribute\Option\Option;

class OptionTemplate extends Option
{
    /**
     * @inheritDoc
     */
    public function __construct(string $name = null)
    {
        parent::__construct($this->name = $name ?: (string) rand());
    }
}
