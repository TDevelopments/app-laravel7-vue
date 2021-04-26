<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleStockRecord;

class SaleBusinessLocation extends Model
{
    protected $fillable = [
        'Name',
        'Address',
        'City',
        'Region',
        'PostalCode',
        'Country',
    ];

    public function SaleStockRecord()
    {
        return $this->belongsTo(SaleStockRecord::class);
    }
}
