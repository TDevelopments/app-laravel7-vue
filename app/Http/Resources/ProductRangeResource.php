<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRangeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'images' => $this->images,
            'model' => $this->model,
            'slug' => $this->slug,
            'colors' => $this->colors,
            'stock' => $this->stock,
            'count' => $this->count,
            'brand' => $this->brand,
            'price_sale' => $this->price_sale,
            'on_sale' => $this->on_sale,
            'catalogue' => $this->catalogue,
            'category' => $this->category,
            'ranges' => $this->ranges,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
