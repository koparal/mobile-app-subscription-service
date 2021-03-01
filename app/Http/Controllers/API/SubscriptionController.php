<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Device;
use App\Models\Subscription;
use App\Traits\VerifyHashTrait;
use App\Http\Requests\CheckSubscription;
use App\Http\Requests\PurchaseSubscription;
use Illuminate\Support\Facades\Cache;


/**
 * Class PurchaseController
 * @package App\Http\Controllers\API
 */
class SubscriptionController extends BaseController
{
    use VerifyHashTrait;

    /**
     * @param PurchaseSubscription $request
     * @return mixed
     */
    public function purchase(PurchaseSubscription $request)
    {
        // Validation
        $request->validated();

        // Request params
        $hash = $request->receipt;
        $clientToken = $request->client_token;
        $expireDate = $request->expire_date;

        // if not exist expire date, add credit until next month
        if (!$expireDate) {
            $expireDate = Carbon::now()->addMonth(1);
        }

        $cacheKey = "purchase-".$clientToken.$hash;

        // 10 min keep in cache the request
        return Cache::remember($cacheKey, 10, function () use ($clientToken, $hash, $expireDate,$request) {

            /** @var Device $device */
            $device = Device::where("client_token", $clientToken)->first();

            // If the client token has a device
            if ($device) {

                // verify hash
                $response = $this->hashVerification($device, $hash);

                if ($response) {

                    $checkSubscription = Subscription::where("device_id", $device->id)->first();

                    // if not subscribed
                    if (!$checkSubscription) {

                        $data = [
                            'device_id' => $device->id,
                            'expire_date' => $expireDate,
                            "status" => SUBSCRIPTON_STATUS_STARTED
                        ];

                        /** @var Subscription $subscription */
                        $subscription = Subscription::create($data);

                        return $this->successResponse([
                            "expire_date" => $subscription->expire_date
                        ]);

                    } else {
                        return $this->errorResponse("You are already a subscriber.", 400);
                    }
                } else {
                    return $this->errorResponse("Verification failed. Please try again.", 201);
                }
            } else {
                return $this->errorResponse("Client token is invalid.", 400);
            }
        });

    }

    /**
     * @param CheckSubscription $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(CheckSubscription $request)
    {
        $request->validated();

        $clientToken = $request->client_token;
        $cacheKey = 'checkSubscription-' . $clientToken;

        // 10 min keep in cache the request
        return Cache::remember($cacheKey, 10, function () use ($clientToken, $request) {

            /** @var Device $device */
            $device = Device::where("client_token", $clientToken)->first();

            if ($device) {

                $deviceSubscription = $device->subscription;

                if ($deviceSubscription) {
                    return $this->successResponse([
                        "status" => SUBSCRIPTON_STATUSES[$deviceSubscription->status],
                        "expire_date" => $deviceSubscription->expire_date
                    ]);
                }

            } else {
                return $this->errorResponse("Client token is invalid.", 400);
            }

            return $this->errorResponse("Something went wrong. Try again please.", 400);
        });
    }
}


