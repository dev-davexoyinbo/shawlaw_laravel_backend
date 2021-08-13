<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
        'other_features' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end method user
}//end class Property
