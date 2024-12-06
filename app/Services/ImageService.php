<?php

namespace App\Services;
use App\Models\Albuum;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Create a new class instance.
     */
    public function uploadImage(Request $request)
    {
        // Check if the request has a file under 'image' or 'name'
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        } elseif ($request->hasFile('name')) {
            $image = $request->file('name');
        } else {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        // Get the current date and time for naming
        $image = $request->file('name');
        $d = date('Y-m-d H:i', time());
        $newImageName = $d . '@' . $image->getClientOriginalName();
        $image->storeAs('Albums', $image, 'public');
        return $image;
    }

    public function storeImage(Request $request, $album)
    {

        $image = $request->file('name');
        $d = date('Y-m-d H:i', time());

        foreach ($image as $images) {
            $newImageName = $d . '@' . $images->getClientOriginalExtension();
            $images->storeAs('Albums', $newImageName, 'public');
            Image::create([
                'name' => $newImageName,
                'album_id' => $album->id
            ]);
        }
        return $newImageName;
    }
    public function addAlbum(Request $request, $add)
    {

        $album = Albuum::create([
            'add_id' => $request->add_Id,
            'name' => $add->title,
        ]);
        return $album;

    }
}
