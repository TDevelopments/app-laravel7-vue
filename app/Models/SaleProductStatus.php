<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleStockRecord;

class SaleProductStatus extends Model
{
    protected $fillable = [
        'StatusName'
    ];

    public function SaleStockRecord()
    {
        return $this->belongsTo(SaleStockRecord::class);
    }
}
