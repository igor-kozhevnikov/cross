<?php

declare(strict_types=1);

namespace Cross\Cross\Commands;

use Cross\Attributes\Attributes;
use Cross\Attributes\AttributesInterface;
use Cross\Attributes\AttributesKeeper;
use Cross\Commands\Attributes\Description;
use Cross\Commands\Attributes\Name;
use Cross\Commands\Attributes\Setup;
use Cross\Commands\ShellCommand;
use Cross\Messages\Messages;
use Cross\Package\Package;
use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;

/**
 * @method Messages messages()
 */
#[Name('config')]
#[Description('Copies the config file to the working directory')]
class Config extends ShellCommand
{
    /**
     * TTY mode.
     */
    protected bool $tty = true;

    /**
     * Package.
     */
    protected Package $package;

    /**
     * Defines a package.
     */
    #[Setup]
    protected function package(): void
    {
        $this->package = new Package();
    }

    /**
     * @inheritDoc
     */
    protected function attributes(): AttributesInterface|AttributesKeeper
    {
        return Attributes::make()
            ->argument('ext')->optional()->default('php')->description('Extension of config file');
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): Prepare
    {
        $exist = file_exists($this->package->getAlternativeConfigPath());

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
        $source = $this->package->getBaseConfigPath();
        $destination = $this->package->getAlternativeConfigPath();

        return "cp $source $destination";
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
