<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Range;

class ProductRange extends Model
{
    use Sluggable;
    
    protected $casts = [
        'colors' => 'array',
        'description' => 'array',
        'images' => 'array',
    ];

    protected $fillable = [
        'name',
        'description',
        'images',
        'model',
        'colors',
        'stock',
        'brand',
        'price_sale',
        'on_sale',
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
    
    public function ranges()
    {
        return $this->hasMany(Range::class);
    }
}
