<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\FailedCallbackEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PrepareRetryFailedCallbackEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        FailedCallbackEvent::where("status", FAILED_CALLBACK_EVENT_STATUS_FAILED)
            ->chunk(500, function ($failedEvents) {
                /** @var FailedCallbackEvent $failedEvent */
                foreach ($failedEvents as $failedEvent) {
                    RetryFailedCallbackEvent::dispatch($failedEvent);
                }
            });
    }
}
