<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\Subscription\SubscriptionUpdated;

/**
 * Class UpdateExpiredSubscription
 * @package App\Jobs
 */
class UpdateExpiredSubscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Subscription
     */
    public $subscription;
    /**
     * @var
     */
    public $hash;
    /**
     * @var boolean
     */
    public $verificationResponse;

    /**
     * UpdateExpiredSubscription constructor.
     * @param Subscription $subscription
     * @param $hash
     * @param $verificationResponse
     */
    public function __construct(Subscription $subscription, $hash, $verificationResponse)
    {
        $this->subscription = $subscription;
        $this->hash = $hash;
        $this->verificationResponse = $verificationResponse;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->verificationResponse){

            $this->subscription->update([
                "status"=> SUBSCRIPTON_STATUS_CANCELED,
                "sync_status"=> SUBSCRIPTON_SYNC_STATUS_FAILED,
                "log"=> "The subscription has been canceled. Receipt : ".$this->hash,
            ]);

            // Event dispatch
            event(new SubscriptionUpdated($this->subscription));

        }else{

            $this->subscription->update([
                "sync_status"=> SUBSCRIPTON_SYNC_STATUS_FAILED,
                "log"=> "Receipt verification failed or rate limit error. Receipt : ". $this->hash,
            ]);

        }
    }
}
