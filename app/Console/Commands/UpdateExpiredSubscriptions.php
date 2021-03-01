<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:expired-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command updates subscriptions that have been expired.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Dispatch the jobs.
        \App\Jobs\PrepareUpdateExpiredSubscriptions::dispatch();
    }
}
