<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

/**
 * Class TestCallbackUrlController
 * @package App\Http\Controllers\API
 */
class TestCallbackUrlController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        // Response codes
        $responseCodes = [200,500];
        // return random response type
        return response()->json([], $responseCodes[rand(0, 1)]);
    }
}


