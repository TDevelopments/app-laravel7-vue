<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;

class SaleProductUnit extends Model
{
    protected $fillable = [
        'UnitName',
        'UnitShortName',
    ];

    public function SaleProduct()
    {
        return $this->belongs(SaleProduct::class);
    }
}
