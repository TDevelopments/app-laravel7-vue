<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;
use App\Models\SalePicture;

class SaleCategory extends Model
{

    protected $fillable = [
        'CategoryName',
        'CategoryDescription',
        'Active',
    ];

    public function SaleProducts()
    {
        return $this->belongsToMany(SaleProduct::class)->withTimestamps();
    }

    public function SalePictures()
    {
        return $this->belongsToMany(SalePicture::class, 'sale_picture_sale_category')->withTimestamps();
    }
}
