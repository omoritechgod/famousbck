<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'customer_name',
        'email',
        'company_name',
        'phone',
        'additional_requirements',
        'urgency',
        'products'
    ];

    protected $casts = [
        'products' => 'array',
    ];
}
