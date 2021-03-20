<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductRange;

class Range extends Model
{
    // use HasFactory;

    protected $fillable = [
        'min',
        'max',
        'price',
        'product_range_id'
    ];

    public function productRange()
    {
        return $this->belongsTo(ProductRange::class);
    }
}
