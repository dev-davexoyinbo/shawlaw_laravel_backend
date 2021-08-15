<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];



    protected $casts = [
        'gallery' => 'array',
        'other_features' => 'array'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($property) {
            $previousGallery = $property->gallery;
            //delete previous files in gallery
            if ($previousGallery && count($previousGallery) > 0) {
                foreach ($previousGallery as $previousUrl) {
                    $deletePath = preg_replace("/^\/storage/", "", $previousUrl);
                    Storage::disk("public")->delete($deletePath);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end method user
}//end class Property
