<?php
namespace App\helpers;

class SendResponse
{
    public static function sendResponse($code = null, $message = null, $data = null)
    {
        $response = [
            'status' => $code,
            'message' => $message,
            'data' => $data,

        ];
        return response()->json($response);
    }
}