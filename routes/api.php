<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\HashVerificationController;
use App\Http\Controllers\API\TestCallbackUrlController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);

Route::group(['prefix' => 'subscription'], function () {
    Route::post('purchase', [SubscriptionController::class, 'purchase']);
    Route::post('check', [SubscriptionController::class, 'check']);
});

Route::post('hash-verification', [HashVerificationController::class, 'verify']);
Route::post('test-callback', [TestCallbackUrlController::class, 'test']);

