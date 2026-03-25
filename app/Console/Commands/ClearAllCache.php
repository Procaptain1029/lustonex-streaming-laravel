<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAllCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all types of cache (config, route, view, application cache)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing all cache...');

        // Clear application cache
        Artisan::call('cache:clear');
        $this->info('✓ Application cache cleared');

        // Clear configuration cache
        Artisan::call('config:clear');
        $this->info('✓ Configuration cache cleared');

        // Clear route cache
        Artisan::call('route:clear');
        $this->info('✓ Route cache cleared');

        // Clear view cache
        Artisan::call('view:clear');
        $this->info('✓ View cache cleared');

        // Clear compiled views
        Artisan::call('optimize:clear');
        $this->info('✓ Optimized cache cleared');

        $this->info('🎉 All cache cleared successfully!');
    }
}
