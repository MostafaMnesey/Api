<?php

namespace App\Http\Resources;

use App\Models\Add;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'phone' => $this->phone,
            'image' => $this->name,




        ];
    }
}
