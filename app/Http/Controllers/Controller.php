<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Sends a successful response back to user
     *
     * @param  string  $message success message
     * @param  array  $data  response payload
     * @param  int $code http status code
     * @return json_object
     */
    public function sendResponse($message, $data = [], $code = 200)
    {
        $response = [
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, $code);
    }

    /**
     * Sends a error response back to user
     *
     * @param  string  $message error message
     * @param  array  $errors  response payload
     * @param  int $code http status code
     * @return json_object
     */
    public function sendError($message, $errors = [], $code = 400)
    {
        $response = [
            'message' => $message,
            'errors' => $errors
        ];
        return response()->json($response, $code);
    }
}
