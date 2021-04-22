<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleCategory;
use App\Models\SalePicture;
use App\Models\SaleReview;

class SaleProduct extends Model
{
    use Sluggable;

    protected $casts = [
        'Size' => 'array',
        'Color' => 'array',
    ];

    protected $fillable = [
        'Sku',
        'ProductName',
        'ProductDescription',
        'QuantityPerUnit',
        'UnitPrice',
        'SellingPrice',
        'AvailableSize',
        'AvailableColors',
        'AvailableGender',
        'Size',
        'Color',
        'Gender',
        'Discount',
        'UnitWeight',
        'UnitMetric',
        'UnitsOnOrder',
        'UnitsInStock',
        'ProductAvailable',
        'DiscountAvailable',
    ];

    public function sluggable(): array
    {
        return [
            'Slug' => [
                'source' => 'ProductName',
                'onUpdate' => true
            ]
        ];
    }

    public function SaleCategories()
    {
        return $this->belongsToMany(SaleCategory::class)->withTimestamps();
    }

    public function SalePictures()
    {
        return $this->belongsToMany(SalePicture::class)->withTimestamps();
    }

    public function Reviews()
    {
        return $this->hasMany(SaleReview::class);
    }

    public function hasAnyCategory($categories)
    {
        if (is_array($categories)) {
            foreach ($categories as $category) {
                if ($this->hasCategory($category)) {
                    return true;
                }
            }
        } else {
            if ($this->hasCategory($categories)) {
                 return true; 
            }   
        }
        return false;
    }
    
    public function hasCategory($category)
    {
        if ($this->SaleCategories()->where('CategoryName', $category)->first()) {
            return true;
        }
        return false;
    }
}
