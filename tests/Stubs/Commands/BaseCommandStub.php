<?php

declare(strict_types=1);

namespace Cross\Tests\Stubs\Commands;

use Cross\Commands\Attributes\Attributes;
use Cross\Commands\BaseCommand;
use Cross\Commands\Statuses\Exist;
use Cross\Commands\Statuses\Prepare;
use Cross\Tests\Stubs\Accessible;
use Cross\Tests\Utils\Str;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @method mixed argument(string $name)
 * @method mixed option(string $name)
 * @method int execute(InputInterface $input, OutputInterface $output)
 */
class BaseCommandStub extends BaseCommand
{
    use Accessible;

    /**
     * @inheritDoc
     */
    public function __construct(
        public string $name = '',
        public string $description = '',
        public array $aliases = [],
        public bool $hidden = false,
        public ?Attributes $attributes = null,
        public ?Prepare $prepare = null,
        public ?ExceptionInterface $run = null,
    ) {
        $this->name = $name ?: Str::random();
        $this->input = new ArrayInput([]);
        $this->output = new SymfonyStyle($this->input, new BufferedOutput());
        parent::__construct($this->name);
    }

    /**
     * @inheritDoc
     */
    public function prepare(): Prepare
    {
        return is_null($this->prepare) ? parent::prepare() : $this->prepare;
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Exist
    {
        return Exist::Success;
    }
}
