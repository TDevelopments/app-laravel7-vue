<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SaleStockRecord;

class SaleCustomer extends Model
{
    protected $fillable = [
        'FirstName',
        'LastName',
        'Address1',
        'Address2',
        'City',
        'State',
        'PostalCode',
        'Country',
        'Phone',
        'Email',
        'ShipAddress',
        'ShipCity',
        'ShipRegion',
        'ShipPostalCode',
        'ShipCountry',
        'BillingAddress',
        'BillingCity',
        'BillingRegion',
        'BillingPostalCode',
        'BillingCountry',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function SaleStockRecord()
    {
        return $this->belongsTo(SaleStockRecord::class);
    }
}
