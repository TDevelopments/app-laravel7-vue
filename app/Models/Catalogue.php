<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductRange;
use App\Models\Arrival;
use App\Models\Order;

class Catalogue extends Model
{
    // use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $casts = [
        // 'arrival_places' => 'array'
    ];

    protected $fillable = [
        'name',
        'image',
        'is_available',
        'coin',
        'quota_price',
        'quota_date',
        'minimum_investment',
        'first_payment',
        'date_first_payment',
        'second_payment',
        'date_second_payment',
    ];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productRanges()
    {
        return $this->hasMany(ProductRange::class);
    }

    public function arrivals()
    {
        return $this->hasMany(Arrival::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
