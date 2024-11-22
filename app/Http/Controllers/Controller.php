<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function sendResponse($result, $message) {

        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, 200);
    }

    public function sendError($message, $error = [], $code = 404) {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($error)) {
            $response['data'] = $error;
        }

        return response()->json($response, $code);
    }
}
