<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    protected $fillable = [
        'OrderDate',
        'ShipDate',
        'SalesTax',
        'Delete',
        'sale_customer_id',
        'sale_state_order_id',
        'sale_payment_id',
    ];

    public function SaleCustomer()
    {
        return $this->belongsTo(SaleCustomer::class);
    }

    public function SaleOrderDetails()
    {
        return $this->belongsTo(SaleOrderDetails::class);
    }

    public function SaleStateOrder()
    {
        return $this->belongsTo(SaleStateOrder::class);
    }

    public function SalePayment()
    {
        return $this->belongsTo(SalePayment::class);
    }
}
