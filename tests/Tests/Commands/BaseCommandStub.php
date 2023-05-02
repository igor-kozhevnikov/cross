<?php

declare(strict_types=1);

namespace Cross\Tests\Commands;

use Cross\Commands\Attributes\AttributesInterface;
use Cross\Commands\BaseCommand;
use Cross\Commands\Messages\MessagesInterface;
use Cross\Commands\Statuses\Exist;
use Cross\Commands\Statuses\Prepare;
use Cross\Tests\Utils\Accessible;
use Cross\Tests\Utils\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property string $name
 * @property string $description
 * @property array $aliases
 * @property bool $hidden
 * @property ?AttributesInterface $attributes
 * @property ?MessagesInterface $messages
 *
 * @method string name()
 * @method string description()
 * @method array aliases()
 * @method bool hidden()
 * @method void configure()
 * @method array arguments()
 * @method mixed argument(string $name)
 * @method array options()
 * @method mixed option(string $name)
 * @method int execute(InputInterface $input, OutputInterface $output)
 */
class BaseCommandStub extends BaseCommand
{
    use Accessible;

    /**
     * Prepare.
     */
    public ?Prepare $prepare = null;

    /**
     * Exist.
     */
    public ?Exist $exist = Exist::Success;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct($this->name = Str::random());
    }

    /**
     * @inheritDoc
     */
    public function prepare(): Prepare
    {
        return $this->prepare ?? parent::prepare();
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        return $this->exist;
    }
}
