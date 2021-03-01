<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\HashVerificationRequest;
use App\Traits\VerifyHashTrait;


/**
 * Class HashVerificationController
 * @package App\Http\Controllers\API
 */
class HashVerificationController extends BaseController
{
    use VerifyHashTrait;

    /**
     * @param HashVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(HashVerificationRequest $request)
    {
        $request->validated();

        $platform = $request->platform;
        $hash = $request->hash;
        $response = null;

        switch ($platform) {

            case GOOGLE_VERIFY_PLATFORM:
                $response = $this->googleVerifyHash($hash);
                break;

            case IOS_VERIFY_PLATFORM:
                $response = $this->iosVerifyHash($hash);
                break;

            default:
                $response = $this->googleVerifyHash($hash);
            }

        if ($response) {

            return $this->successResponse([
                "verify" => true
            ]);

        }

        return $this->errorResponse("Verification failed", 201);
    }
}


