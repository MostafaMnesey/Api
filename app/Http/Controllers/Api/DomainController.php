<?php

namespace App\Http\Controllers\api;

use App\helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomianResource;
use App\Models\Domin;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $domin = Domin::all();
        if ($domin->isEmpty())
            return SendResponse::sendResponse(200, 'domains not found', []);
        else
            return SendResponse::sendResponse(200, 'domains found', DomianResource::collection($domin));
    }
}
