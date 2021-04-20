<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;

class SaleCategory extends Model
{

    protected $casts = [
        'Picture' => 'array',
    ];

    protected $fillable = [
        'CategoryName',
        'CategoryDescription',
        'Picture',
        'Active',
    ];

    public function SaleProducts()
    {
        return $this->belongsToMany(SaleProduct::class)->withTimestamps();
    }
}
