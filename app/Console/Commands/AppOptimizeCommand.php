<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppOptimizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize laravel application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('optimize');

        $this->info('Your application optimized successfully.');
    }
}
