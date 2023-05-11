<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // generate json response with 2 params
    public function sendResponse($result, $message)
    {
        // arrays with keys and values
    	$response = [
            'success' => true,  // successfull response
            'data'    => $result,
            'message' => $message,  // display message
        ];

        // return json response
        return response()->json($response, 200);  // http status code 200 means OK
    }


    // json response for error response
    /**
     * $errorMessages = [] - represents additional error messages
     * $code 404 - represents code status (Not Found)
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        // if not empty, add error details message
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
