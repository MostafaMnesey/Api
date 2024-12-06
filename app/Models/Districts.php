<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $table = 'districts';
    protected $fillable = [
        'name',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    use HasFactory;
}
