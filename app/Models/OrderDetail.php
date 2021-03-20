<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    // use HasFactory;

    protected $fillable = [
        'product_id',
        'product_range_id',
        'order_id',
        'model',
        'sku',
        'price',
        'quantity',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productRange()
    {
        return $this->belongsTo(ProductRange::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
