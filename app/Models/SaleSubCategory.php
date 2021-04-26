<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;

class SaleSubCategory extends Model
{
    protected $fillable = [
        'SubCategoryName',
    ];

    public function SaleProduct()
    {
        return $this->belongs(SaleProduct::class);
    }
}
