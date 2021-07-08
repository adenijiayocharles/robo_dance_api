<?php
namespace App\Http\Traits;

trait Response {
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
            'status' => 'success',
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
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ];
        return response()->json($response, $code);
    }
}

