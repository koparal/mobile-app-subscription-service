<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use App\Traits\VerifyHashTrait;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class HashVerification
 * @package App\Jobs
 */
class HashVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, VerifyHashTrait;

    /**
     * @var Subscription
     */
    public $subscription;
    /**
     * @var integer
     */
    public $hash;

    /**
     * HashVerification constructor.
     * @param Subscription $subscription
     * @param integer $hash
     */
    public function __construct(Subscription $subscription, int $hash)
    {
        $this->subscription = $subscription;
        $this->hash = $hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $verificationResponse = false;
        $device = $this->subscription->device;

        try {
            $verificationResponse = $this->hashVerification($device, $this->hash);
        } catch (\Exception $e) {
        }

        // Dispatch update expired subscription
        UpdateExpiredSubscription::dispatch($this->subscription, $this->hash, $verificationResponse);
    }
}
