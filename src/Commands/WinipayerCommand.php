<?php

namespace Winipayer\Winipayer\Commands;

use Illuminate\Console\Command;

class WinipayerCommand extends Command
{
    public $signature = 'package-winipayer-test';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
