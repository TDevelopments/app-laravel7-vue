<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\ProductRange;

class Category extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productRange()
    {
        return $this->belongsTo(ProductRange::class);
    }
}
