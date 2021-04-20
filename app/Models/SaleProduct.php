<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleCategory;

class SaleProduct extends Model
{
    use Sluggable;

    protected $casts = [
        'Size' => 'array',
        'Color' => 'array',
        'Picture' => 'array',
    ];

    protected $fillable = [
        'Sku',
        'ProductName',
        'ProductDescription',
        'QuantityPerUnit',
        'UnitPrice',
        'AvailableSize',
        'AvailableColors',
        'Size',
        'Color',
        'Discount',
        'UnitWeight',
        'UnitMetric',
        'UnitsOnOrder',
        'UnitsInStock',
        'ProductAvailable',
        'DiscountAvailable',
        'Picture',
        'Ranking',
        'sale_category_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'ProductName',
                'onUpdate' => true
            ]
        ]
    }

    public function SaleCategories()
    {
        return $this->belongsToMany(SaleCategory::class)->withTimestamps();
    }
}
