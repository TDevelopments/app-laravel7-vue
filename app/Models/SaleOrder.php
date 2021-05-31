<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{

    protected $casts = [
        'Delete' => 'boolean',
        'OrderDate' => 'datetime',
    ];

    protected $fillable = [
        'OrderDate',
        'ShipDate',
        'SalesTax',
        'Delete',
        'sale_customer_id',
        'sale_state_order_id',
        'user_id',
    ];

    public function SaleCustomer()
    {
        return $this->belongsTo(SaleCustomer::class);
    }

    public function SaleOrderDetails()
    {
        return $this->hasMany(SaleOrderDetail::class);
    }

    public function SaleStateOrder()
    {
        return $this->belongsTo(SaleStateOrder::class);
    }

    public function SalePayment()
    {
        return $this->hasOne(SalePayment::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
