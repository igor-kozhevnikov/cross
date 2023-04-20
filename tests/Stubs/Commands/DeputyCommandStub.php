<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\DeputyCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Tests\Stubs\Accessible;
use Cross\Tests\Utils\Str;

/**
 * @method string deputy()
 * @method array parameters()
 * @method Exist handle()
 */
class DeputyCommandStub extends DeputyCommand
{
    use Accessible;

    /**
     * @inheritDoc
     */
    public function __construct(
        public string $deputy = '',
        public array $parameters = [],
    ) {
        $this->name = Str::random();
        parent::__construct($this->name);
    }

    /**
     * @inheritDoc
     */
    public function call(?string $name = null, array $input = []): Exist
    {
        return Exist::Success;
    }
}
