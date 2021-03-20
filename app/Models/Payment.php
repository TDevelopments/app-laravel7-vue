<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    // use HasFactory;

    protected $fillable = [
        'image',
        'mount',
        'payment_date',
        'order_id',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
