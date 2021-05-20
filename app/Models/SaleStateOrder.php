<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleStateOrder extends Model
{
    protected $fillable = [
        'Name',
        'ShortName',
    ];

    public function SaleOrder()
    {
        return $this->hasOne(SaleOrder::class);
    }
}
