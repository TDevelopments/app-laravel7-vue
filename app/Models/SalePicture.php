<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;
use App\Models\SaleCategory;

class SalePicture extends Model
{
    protected $fillable = [
        'PictureName',  
        'PicturePath',  
    ];
    
    public function SaleProducts()
    {
        return $this->belongsToMany(SaleProduct::class)->withTimestamps();
    }

    public function SaleCategories()
    {
        return $this->belongsToMany(SaleCategory::class)->withTimestamps();
    }
}
