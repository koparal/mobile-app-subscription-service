<?php

namespace App\Traits;

use App\Models\Device;
use GuzzleHttp\Client;

trait VerifyHashTrait
{
    /**
     * @param $device
     * @param $hash
     * @throws mixed
     */
    public function hashVerification($device, $hash)
    {
        /** @var Device $device */
        // Instance client
        $client = new Client(['base_uri' => getBaseUrl()]);
        $os = $device->operating_system ?? GOOGLE_VERIFY_PLATFORM;

        // Headers
        $headers = [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Authentication' => "Basic " . $device->application->username . ":" . $device->application->password
            ],
        ];

        $params = [
            'platform' => $os,
            'hash' => $hash
        ];

        // Request
        $response = $client->request('POST', '/api/hash-verification', [
            $headers,
            'form_params' => $params]);

        // Response data
        $responseData = $response->getBody()->getContents();
        $responseData = json_decode($responseData, true);

        return $responseData['status'];
    }

    /**
     * @param $hash
     * @return bool
     */
    public function googleVerifyHash($hash): bool
    {
        $lastChar = (int)substr($hash, -1);
        $lastTwoChar = (int)substr($hash, -2);

        // Check the chars divisible into 2 and 6
        if ($lastChar % 2 == 0 && $lastTwoChar % 6 == 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $hash
     * @return boolean
     */
    public function iosVerifyHash($hash) : bool
    {
        $lastChar = (int)substr($hash, -1);
        $lastTwoChar = (int)substr($hash, -2);

        // Check the chars divisible into 2 and 6
        if ($lastChar % 2 == 0 && $lastTwoChar % 6 == 0) {
            return true;
        }

        return false;
    }
}
