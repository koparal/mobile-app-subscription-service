<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class PrepareUpdateExpiredSubscriptions
 * @package App\Jobs
 */
class PrepareUpdateExpiredSubscriptions implements ShouldQueue
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
        Subscription::where("expire_date", "<=", Carbon::now())
            ->where("sync_status",SUBSCRIPTON_SYNC_STATUS_FAILED)
            ->chunk(500, function ($subscriptions) {
                /** @var Subscription $subscription */
                foreach ($subscriptions as $subscription) {
                    $hash = $this->generateSampleHash();
                    HashVerification::dispatch($subscription, $hash);
                }
            });
    }

    /**
     * @return int
     */
    public function generateSampleHash()
    {
        $sampleReceipts = [
            123451336,
            964654772,
            646542153,
            124124448
        ];

        return $sampleReceipts[rand(0, 3)];
    }
}
