<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'specifications' => 'array',
        'features' => 'array',
        'images' => 'array',
        'availability' => 'boolean',
        'featured' => 'boolean',
    ];
}
