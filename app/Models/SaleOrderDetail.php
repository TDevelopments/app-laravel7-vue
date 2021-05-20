<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrderDetail extends Model
{
    protected $fillable = [
        'Price',
        'Quantity',
        'ProductSku',
        'Discount',
        'Size',
        'Color',
        'Total',
        'ShipDate',
        'sale_order_id',
        'sale_product_id',
    ];
}
