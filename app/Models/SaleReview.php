<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;

class SaleReview extends Model
{
    protected $fillable = [
        'sale_product_id',
        'NameUser',
        'Review',
        'Star',
    ];

    public function Product()
    {
        return $this->belongsTo(SaleProduct::class);
    }
}
