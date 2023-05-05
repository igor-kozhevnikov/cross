<?php

declare(strict_types=1);

namespace Tests\Commands;

use Cross\Attributes\AttributesInterface;
use Cross\Attributes\AttributesKeeper;
use Cross\Commands\BaseCommand;
use Cross\Messages\MessagesInterface;
use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tests\Helpers\Accessible;

/**
 * @property string $name
 * @property string $description
 * @property array $aliases
 * @property bool $hidden
 * @property MessagesInterface $messages
 * @property null|AttributesInterface|AttributesKeeper $attributes
 *
 * @method void configure()
 * @method string name()
 * @method string description()
 * @method array aliases()
 * @method bool hidden()
 * @method array messages()
 * @method AttributesInterface attributes()
 * @method array arguments()
 * @method mixed argument(string $name)
 * @method array options()()
 * @method mixed option(string $name)
 */
class BaseCommandTemplate extends BaseCommand
{
    use Accessible;

    /**
     * Prepare return.
     */
    public ?Prepare $prepare = null;

    /**
     * Handle return.
     */
    public Exist $handle = Exist::Success;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->name = (string) rand();
        parent::__construct();
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
        return $this->handle;
    }

    /**
     * @inheritDoc
     */
    public function execute(?InputInterface $input = null, ?OutputInterface $output = null): int
    {
        $input ??= new ArrayInput([]);
        $output ??= new SymfonyStyle($input, new BufferedOutput());
        return parent::execute($input, $output);
    }

    /**
     * @inheritDoc
     */
    public function run(?InputInterface $input = null, ?OutputInterface $output = null): int
    {
        $input ??= new ArrayInput([]);
        $output ??= new SymfonyStyle($input, new BufferedOutput());
        return parent::run($input, $output);
    }
}
