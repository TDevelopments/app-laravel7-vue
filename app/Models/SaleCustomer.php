<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SaleStockRecord;

class SaleCustomer extends Model
{
    protected $fillable = [
        'FullName',
        'Dni',
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

    public function SaleOrder()
    {
        return $this->hasMany(SaleOrder::class);
    }
    
    function scopeWithName($query, $name)
    {
        // Split each Name by Spaces
        $names = explode(" ", $name);
    
        // Search each Name Field for any specified Name
        return $this->where(function($query) use ($names) {
            $query->whereIn('FirstName', $names);
            $query->orWhere(function($query) use ($names) {
                $query->whereIn('LastName', $names);
            });
        });
    }
}
