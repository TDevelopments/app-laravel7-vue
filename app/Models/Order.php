<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Catalogue;
use App\Models\Payment;

class Order extends Model
{
    // use HasFactory;

    protected $fillable = [
        'status',
        'total_order',
        'catalogue_id',
        'user_id'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
