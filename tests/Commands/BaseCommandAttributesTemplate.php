<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Commands\Attributes\Aliases;
use Cross\Commands\Attributes\Description;
use Cross\Commands\Attributes\Hidden;
use Cross\Commands\Attributes\Name;
use Cross\Commands\BaseCommand;
use Cross\Statuses\Exist;
use Tests\Helpers\Accessible;

/**
 * @property string $name
 * @property string $description
 * @property array $aliases
 * @property bool $hidden
 *
 * @method void configure()
 * @method string name()
 * @method string description()
 * @method array aliases()
 * @method bool hidden()
 */
#[Name('tiger')]
#[Description('a danger animal')]
#[Aliases('tigar', 'tygr', 'tijger')]
#[Hidden]
class BaseCommandAttributesTemplate extends BaseCommand
{
    use Accessible;

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        return Exist::Success;
    }
}
