<?php

namespace App\Http\Controllers\api;

use App\helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(NewMessageRequest $request)
    {
        $data = $request->validated();
        $record = Message::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],

        ]);
        if ($record)
            return SendResponse::sendResponse(201, 'message sent  successfully', []);
        else
            return SendResponse::sendResponse(200, 'message not send', []);
    }

}
