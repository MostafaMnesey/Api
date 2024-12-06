<?php

namespace App\Http\Controllers\api;

use App\helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictsResource;
use App\Models\Districts;
use Illuminate\Http\Request;

class DistrictsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $Districts = Districts::where('city_id', $request->input('city'))->get();
        if ($Districts->isEmpty())
            return SendResponse::sendResponse(200, 'Districts For this city Is Empty', []);
        else
            return SendResponse::sendResponse(200, 'Districts Found', DistrictsResource::collection($Districts));
    }
}
