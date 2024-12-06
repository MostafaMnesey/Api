<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";
    protected $fillable = ["name"];
    public function Districts()
    {
        return $this->hasMany(Districts::class);
    }
    use HasFactory;
}
