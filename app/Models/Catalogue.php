<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Arrival;

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

    public function arrivals()
    {
        return $this->hasMany(Arrival::class);
    }

}
