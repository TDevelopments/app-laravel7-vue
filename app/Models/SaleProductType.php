<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;

class SaleProductType extends Model
{
    protected $fillable = [
        'TypeName',
    ];

    public function SaleProduct()
    {
        return $this->belongs(SaleProduct::class);
    }
}
