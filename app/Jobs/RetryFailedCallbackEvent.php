<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use App\Models\FailedCallbackEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetryFailedCallbackEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $failedEvent;

    public function __construct(FailedCallbackEvent $failedEvent)
    {
        $this->failedEvent = $failedEvent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $application = $this->failedEvent->application;

        if ($application) {

            $params = [
                'appId' => $this->failedEvent->app_id,
                'deviceId' => $application->device_id,
                'event' => $this->failedEvent->event_status
            ];

            // Headers
            $headers = [
                'headers' => [
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
            ];

            try {
                $response = $client->request('POST', $application->callback_url, [$headers, 'form_params' => $params]);

                // Set failed event status according by response status
                if ($response->getStatusCode() != 500) {
                    $this->failedEvent->status = FAILED_CALLBACK_EVENT_STATUS_SUCCESS;
                    $this->failedEvent->save();
                }

            } catch (\Exception $e) {
            }
        }
    }
}
