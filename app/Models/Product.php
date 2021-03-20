<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogue;
use App\Models\Category;

class Product extends Model
{
    use Sluggable;
    
    protected $casts = [
        'colors' => 'array',
        'description' => 'array',
        'images' => 'array',
    ];

    protected $fillable = [
        'name',
        'sku',
        'description',
        'images',
        'video',
        'model',
        'colors',
        'stock',
        'brand',
        'price_sale',
        'on_sale',
        'price_unit',
        'price_group',
        'quantity_group',
        'type_group',
        'catalogue_id',
        'category_id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'model',
                'onUpdate' => true
            ]
        ];
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setSkuAttribute($value)
    {
         $this->attributes['sku'] = strtoupper($value);
    }

}
