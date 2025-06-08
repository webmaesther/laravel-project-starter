<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

final class ErrorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'error';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Throws an exception';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        return SymfonyCommand::FAILURE;
    }
}
