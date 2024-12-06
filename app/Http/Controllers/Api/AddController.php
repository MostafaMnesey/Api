<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserAdd;
use App\Http\Resources\AddResource;
use App\Models\Add;
use Illuminate\Http\Request;
use App\helpers\SendResponse;
use App\Http\Resources\Album;
use App\Services\ImageService;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class AddController extends Controller
{
    protected $ImageService;
    public function __construct()
    {
        $this->ImageService = new ImageService();
    }
    public function index(Request $request)
    {
        $adds = Add::latest()->paginate(1);  // Changed to 10 for better pagination example

        if ($adds->isEmpty()) {
            return SendResponse::sendResponse(200, 'adds not found', []);
        }

        $data = [
            'records' => AddResource::collection($adds->items()),
            'pagination' => [
                'current_page' => $adds->currentPage(),
                'per_page' => $adds->perPage(),
                'total' => $adds->total(),
                'last_page' => $adds->lastPage(),
                'links' => [
                    'first' => $adds->url($adds->currentPage()),
                    'last' => $adds->url($adds->lastPage()),

                ]
            ]
        ];

        return SendResponse::sendResponse(200, 'adds found', $data);
    }
    public function latest(Request $request)
    {
        $adds = Add::latest()->take(2)->get();
        if ($adds->isEmpty()) {
            return SendResponse::sendResponse(200, 'adds not found', []);
        } else
            return SendResponse::sendResponse(200, 'adds found', AddResource::collection($adds));
    }
    public function domain($id)
    {

        $adds = Add::where('id', $id)->latest()->paginate(1);  // Changed to 10 for better pagination example

        if ($adds->isEmpty()) {
            return SendResponse::sendResponse(200, 'adds not found', []);
        }

        $data = [
            'records' => AddResource::collection($adds->items()),
            'pagination' => [
                'current_page' => $adds->currentPage(),
                'per_page' => $adds->perPage(),
                'total' => $adds->total(),
                'last_page' => $adds->lastPage(),
                'links' => [
                    'first' => $adds->url($adds->currentPage()),
                    'last' => $adds->url($adds->lastPage()),

                ]
            ]
        ];

        return SendResponse::sendResponse(200, 'adds found', $data);

    }
    public function search(Request $request)
    {

        if ($request->has('search')) {
            $search = $request->input('search');
            $adds = Add::where('title', 'like', '%' . $search . '%')->latest()->paginate(10);

            return SendResponse::sendResponse(200, 'adds found', AddResource::collection($adds));
        } else {
            $adds = Add::latest()->paginate(10);
            if ($adds->isEmpty()) {
                return SendResponse::sendResponse(200, 'adds not found', []);
            } else
                return SendResponse::sendResponse(200, 'adds found', AddResource::collection($adds));
        }
    }
    public function create(CreateUserAdd $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['name'] = $this->ImageService->uploadImage($request);
        $data['album'] = $request->album;


        $record = Add::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'text' => $data['text'],
            'phone' => $data['phone'],
            'domain_id' => $data['domain_id'],
            'image' => $data['name'],
        ]);


        if ($record) {

            return SendResponse::sendResponse(201, 'add created successfully', new AddResource($record));

        }


    }


    public function update(CreateUserAdd $request, $Add_id = null)
    {
        $add = Add::findOrFail($Add_id);
        if ($add->user_id != auth()->user()->id)
            return SendResponse::sendResponse(403, 'Forpidden', []);

        $data = $request->validated();
        $record = Add::where('id', $Add_id)->update($data);
        if ($record) {
            return SendResponse::sendResponse(201, 'add updated successfully', new AddResource($add));
        }
    }
    public function delete($Add_id)
    {
        $add = Add::findOrFail($Add_id);
        if ($add->user_id != auth()->user()->id)
            return SendResponse::sendResponse(403, 'Forpidden', []);
        $add = Add::where('id', $Add_id);
        $add->delete();

        if ($add)
            return SendResponse::sendResponse(200, 'add deleted successfully', []);
        if (!$add)
            return SendResponse::sendResponse(404, 'add not found', []);

    }
    public function myAdds(Request $request)
    {
        $adds = Add::where('user_id', auth()->user()->id)->latest()->paginate(1);
        if ($adds->isEmpty()) {
            return SendResponse::sendResponse(200, 'adds not found', []);
        } else {
            $data = [
                'records' => AddResource::collection($adds->items()),
                'pagination' => [
                    'current_page' => $adds->currentPage(),
                    'per_page' => $adds->perPage(),
                    'total' => $adds->total(),
                    'last_page' => $adds->lastPage(),
                    'links' => [
                        'first' => $adds->url($adds->currentPage()),
                        'last' => $adds->url($adds->lastPage()),

                    ]
                ]
            ];
            return SendResponse::sendResponse(200, 'adds found', $data);

        }
    }
    public function addAlbum(Request $request, $id)
    {
        $add = Add::findOrFail($id);
        if ($add->user_id != auth()->user()->id)
            return SendResponse::sendResponse(403, 'Forpidden', []);



        $request->validate([
            'album' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        $album = $this->ImageService->addAlbum($request, $add);

        $image = $this->ImageService->storeImage($request, $album);

        if ($album)
            return SendResponse::sendResponse(201, 'Album created successfully', new Album($album));
    }

}