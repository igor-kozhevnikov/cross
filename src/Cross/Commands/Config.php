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
use Cross\Package\Config\Extension;
use Cross\Package\Package;
use Cross\Statuses\Exist;
use Cross\Statuses\Prepare;
use ValueError;

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
            ->argument('extension')
                ->optional()
                ->default(Extension::PHP->value)
                ->description('Extension of config file');
    }

    /**
     * @inheritDoc
     */
    protected function prepare(): Prepare
    {
        $extension = $this->argument('extension');

        try {
            $path = $this->package->getAlternativeConfigPath($extension);
        } catch (ValueError) {
            return $this->messages()->error("Invalid extension '$extension'")->stop();
        }

        $exist = file_exists($path);

        if ($exist) {
            return $this->messages()->error('Config already exists')->stop();
        }

        return Prepare::Continue;
    }

    /**
     * @inheritDoc
     * @return string|array<array-key, int|string>
     */
    protected function command(): string|array
    {
        $extension = $this->argument('extension');
        $source = $this->package->getBaseConfigPath($extension);
        $destination = $this->package->getAlternativeConfigPath($extension);

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
