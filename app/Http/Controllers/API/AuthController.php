<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use App\Models\Application;
use App\Http\Requests\RegisterDevice;
use Illuminate\Support\Facades\Cache;

/**
 * Class AuthController
 * @package App\Http\Controllers\API
 */
class AuthController extends BaseController
{
    /**
     * @param RegisterDevice $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterDevice $request)
    {
        // Validate request
        $request->validated();

        $uId = $request->uid;
        $appId = $request->app_id;
        $cacheKey = 'register-' . $uId . $appId;

        // 10 min keep in cache the request
        return Cache::remember($cacheKey, 10, function () use ($uId, $appId, $request) {

            /** @var Device $device */
            $device = Device::where("uid", $uId)->where("app_id", $appId)->first();
            // Check device
            if (!$device) {

                $data = array_merge(['client_token' => generateClientToken()], $request->all());

                $device = Device::create($data);

                if ($device) {

                    Application::firstOrCreate(
                        [
                            'device_id' => $device->id,
                            'username' => $request->username ?? "",
                            'password' => $request->password ? encrypt($request->password) : encrypt(""),
                            'callback_url' => getBaseUrl() . "api/test-callback"
                        ]
                    );

                }

            } else {
                $device->update($request->all());
            }

            return $this->successResponse([
                'client_token' => $device->client_token
            ]);
        });
    }

}


