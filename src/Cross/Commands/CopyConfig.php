<?php

declare(strict_types=1);

namespace Cross\Cross\Commands;

use Cross\Commands\ShellCommand;
use Cross\Messages\Messages;
use Cross\Package\Package;
use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;

/**
 * @method Messages messages()
 */
class CopyConfig extends ShellCommand
{
    /**
     * Name.
     */
    protected string $name = 'cross:config';

    /**
     * TTY mode.
     */
    protected bool $tty = true;

    /**
     * Source file.
     */
    protected string $source;

    /**
     * Destination file.
     */
    protected string $destination;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $package = new Package();
        $this->source = $package->getBaseConfigPath();
        $this->destination = $package->getAlternativeConfigPath();
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): Prepare
    {
        $exist = file_exists($this->destination);

        if (! $exist) {
            return Prepare::Continue;
        }

        $this->messages()->error('Config already exists');

        return Prepare::Stop;
    }

    /**
     * @inheritDoc
     * @return string|array<array-key, int|string>
     */
    protected function command(): string|array
    {
        return "cp $this->source $this->destination";
    }

    /**
     * @inheritDoc
     */
    protected function after(Exist $exist): void
    {
        if ($exist->isSuccess()) {
            $this->messages()->success('Config has been created');
        } else {
            $this->messages()->error('Config has not been created');
        }
    }
}
