<?php

namespace App\Http\Controllers\api;

use App\helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __invoke(Request $request)
    {
        $City = City::take(5)->get();
        if ($City->isEmpty())
            return SendResponse::sendResponse(200, 'City Is Empty', []);
        else
            return SendResponse::sendResponse(200, 'City Found', CityResource::collection($City));
    }
}
