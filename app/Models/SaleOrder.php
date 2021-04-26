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
    ];
}
