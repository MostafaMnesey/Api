<?php

namespace App\Models;

use App\Models\Albuum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Add extends Model
{
    use HasFactory;
    protected $table = 'adds';
    protected $guarded = [];
    public function albums()
    {
        return $this->hasOne(Albuum::class);
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($add) {
            // احصل على الألبوم المرتبط بالإعلان
            $album = $add->album;

            if ($album) {
                // احذف الصور المرتبطة بالألبوم من التخزين
                foreach ($album->images as $image) {
                    if (Storage::exists('public/Albums/' . $image->name)) {
                        Storage::delete('public/Albums/' . $image->name);
                    }
                }

                // احذف الصور المرتبطة بالألبوم من قاعدة البيانات
                $album->images()->delete();

                // احذف الألبوم نفسه
                $album->delete();
            }
        });
    }
}
