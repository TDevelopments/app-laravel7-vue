<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleCategory;
use App\Models\SaleSubCategory;
use App\Models\SaleProductType;
use App\Models\SaleProductUnit;
use App\Models\SaleBrand;
use App\Models\SalePicture;
use App\Models\SaleReview;
use App\Models\SaleStockRecord;

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
        'UnitsOnOrder',
        'ProductAvailable',
        'DiscountAvailable',
        'sale_category_id',
        'sale_sub_category_id',
        'sale_brand_id',
        'sale_product_unit_id',
        'sale_product_type_id',
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

    public function SaleCategory()
    {
        return $this->belongsTo(SaleCategory::class);
    }

    public function SaleSubCategory()
    {
        return $this->belongsTo(SaleSubCategory::class);
    }

    public function SaleProductType()
    {
        return $this->belongsTo(SaleProductType::class);
    }

    public function SaleProductUnit()
    {
        return $this->belongsTo(SaleProductUnit::class);
    }

    public function SaleBrand()
    {
        return $this->belongsTo(SaleBrand::class);
    }

    public function SalePictures()
    {
        return $this->belongsToMany(SalePicture::class)->withTimestamps();
    }

    public function Reviews()
    {
        return $this->hasMany(SaleReview::class);
    }

    public function SaleStockRecords()
    {
        return $this->hasMany(SaleStockRecord::class);
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
