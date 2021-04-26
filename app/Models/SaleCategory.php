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

    public function SaleProduct()
    {
        return $this->belongsTo(SaleProduct::class);
    }

    public function SalePictures()
    {
        return $this->belongsToMany(SalePicture::class, 'sale_picture_sale_category')->withTimestamps();
    }
}
