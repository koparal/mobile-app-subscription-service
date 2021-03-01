<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

/**
 * Class BaseController
 * @package App\Http\Controllers\API
 */
class BaseController extends Controller
{
    /**
     * @param $result
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($result, $message = null)
    {
        $response = [
            'status' => true,
            'data' => $result
        ];

        if($message){
            $response['message'] = $message;
        }

        return response()->json($response, 200);
    }

    /**
     * @param $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($error, $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
