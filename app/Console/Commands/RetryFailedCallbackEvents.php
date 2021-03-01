<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RetryFailedCallbackEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retry:failed-callback-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command retry failed callback requests';

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
        \App\Jobs\PrepareRetryFailedCallbackEvent::dispatch();
    }
}
