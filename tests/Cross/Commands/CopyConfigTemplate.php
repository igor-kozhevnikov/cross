<?php

declare(strict_types=1);

namespace Tests\Cross\Commands;

use Cross\Cross\Commands\CopyConfig;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tests\Helpers\Accessible;

/**
 * @property string $destination
 */
class CopyConfigTemplate extends CopyConfig
{
    use Accessible;

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
