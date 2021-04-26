<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;

class SaleBrand extends Model
{
    protected $fillable = [
        'BrandName',
        'Note',
    ];

    public function SaleProduct()
    {
        return $this->belongs(SaleProduct::class);
    }
}
