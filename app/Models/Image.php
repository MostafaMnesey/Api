<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Albuum;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $guarded = [];
    public function addAlbum()
    {
        return $this->belongsTo(Albuum::class);
    }
}
