<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the queue jobs once and exit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Run the queue worker but stop when empty
        $this->call('queue:work', [
            '--stop-when-empty' => true,
            '--no-interaction' => true,
            '--quiet' => true,
        ]);

        $this->info('Queue processed successfully.');
    }
}
