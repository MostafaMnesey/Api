<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Albuum extends Model
{
    use HasFactory;
    protected $table = 'albuums';
    protected $guarded = [];

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function add()
    {
        return $this->belongsTo(Add::class);
    }
}
