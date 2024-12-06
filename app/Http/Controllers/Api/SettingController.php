<?php

namespace App\Http\Controllers\Api;

use App\helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $settings = Setting::take(5)->get();
        if ($settings)
            return SendResponse::sendResponse(200, 'setting found', SettingResource::collection($settings));
        else
            return SendResponse::sendResponse(200, 'setting not found', []);
    }
    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $image->storeAs('public/setting', $image->getClientOriginalName());
        dd($image);
    }
}
