<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{

    protected $fillable = [
        'sale_payment_method_id',
        'sale_payment_status_id',
        'TotalAmount',
        'TotalPaid',
        'SellNote',
        'Picture',
        'user_id',
    ];

    public function SaleOrder()
    {
        return $this->hasOne(SaleOrder::class);
    }

}
