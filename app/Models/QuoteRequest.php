<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'company',
        'products',
        'additional_requirements',
        'urgency',
        'status'
    ];

    protected $casts = [
        'products' => 'array',
    ];
        public function items()
    {
        return $this->hasMany(QuoteItem::class, 'quote_request_id');
    }

}
