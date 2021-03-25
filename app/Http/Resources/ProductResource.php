<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'gender' => $this->gender,
            'magnifying' => $this->magnifying,
            'images' => $this->images,
            'model' => $this->model,
            'slug' => $this->slug,
            'colors' => $this->colors,
            'stock' => $this->stock,
            'count' => $this->count,
            'brand' => $this->brand,
            'price_sale' => $this->price_sale,
            'on_sale' => $this->on_sale,
            'price_unit' => $this->price_unit,
            'price_group' => $this->price_group,
            'quantity_group' => $this->quantity_group,
            'type_group' => $this->type_group,
            'category' => $this->category,
            'catalogue' => $this->catalogue,
        ];
    }
}
