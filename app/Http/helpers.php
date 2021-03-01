<?php

// Defines

// Verification platforms
define("IOS_VERIFY_PLATFORM", "iOS");
define("GOOGLE_VERIFY_PLATFORM", "Google");

// Subscription Statuses
define("SUBSCRIPTON_STATUS_CANCELED", 0);
define("SUBSCRIPTON_STATUS_STARTED", 1);
define("SUBSCRIPTON_STATUS_RENAWED", 2);

// Subscription Sync Statuses
define("SUBSCRIPTON_SYNC_STATUS_FAILED", 0);
define("SUBSCRIPTON_SYNC_STATUS_SUCCESS", 1);

// Subscription Sync Statuses
define("FAILED_CALLBACK_EVENT_STATUS_FAILED", 0);
define("FAILED_CALLBACK_EVENT_STATUS_SUCCESS", 1);

define("SUBSCRIPTON_STATUSES", [
    "CANCELED",
    "STARTED",
    "RENAWED"
]);

function generateClientToken()
{
    $token = \Str::random(30);

    if (\App\Models\Device::where(['client_token' => $token])->exists()) {
        return generateClientToken();
    } else {
        return $token;
    }

}

function getBaseUrl()
{
    return env("APP_URL", "http://localhost");
}
