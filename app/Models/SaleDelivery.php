<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleCustomer;
use App\Models\SaleProduct;
use App\Models\User;

class SaleDelivery extends Model
{
    protected $fillable = [
        'sale_customer_id',
        'sale_product_id',
        'user_id',
        'Quantity',
    ];

    public function SaleCustomer()
    {
        return $this->belongsTo(SaleCustomer::class);
    }

    public function SaleProduct()
    {
        return $this->belongsTo(SaleProduct::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
