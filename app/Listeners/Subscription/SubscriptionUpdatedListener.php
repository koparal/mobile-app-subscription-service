<?php

namespace App\Listeners\Subscription;

use GuzzleHttp\Client;
use App\Models\FailedCallbackEvent;
use App\Events\Subscription\SubscriptionUpdated;

class SubscriptionUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SubscriptionUpdated $event
     * @return void
     */
    public function handle(SubscriptionUpdated $event)
    {
        $subscription = $event->subscription;

        $application = $subscription->device->application;

        // Check application and callback url
        if ($application && $application->callback_url && $application->callback_url != "") {

            $subscriptionStatus = SUBSCRIPTON_STATUSES[$subscription->status];

            // Callback notification params
            $params = [
                'appId' => $application->id,
                'deviceId' => $application->device_id,
                'event' => $subscriptionStatus
            ];

            //Client
            $client = new Client();
            // Headers
            $headers = [
                'headers' => [
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
            ];

            $hasError = false;

            try{
                $response = $client->request('POST', $application->callback_url, [$headers,'form_params' => $params]);

                if ($response->getStatusCode() != 500){
                    $hasError = true;
                }

            }catch (\Exception $exception){
            }

            // if response status 500, create failed callback event data
            if ($hasError) {

                FailedCallbackEvent::create([
                    "app_id" => $application->id,
                    "event_status" => $subscriptionStatus,
                    "status" => FAILED_CALLBACK_EVENT_STATUS_FAILED,
                ]);

            }
        }

    }
}
