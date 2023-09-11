<?php

namespace Rupadana\StarsenderApi\Commands;

use Illuminate\Console\Command;

class StarsenderApiCommand extends Command
{
    public $signature = 'starsender-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
