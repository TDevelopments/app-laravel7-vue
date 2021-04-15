<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
        return [
            'id' => $this->id,
            'product' => $this->product,
            'product_range' => $this->productRange,
            'price' => $this->price,
            'meta' => $this->meta,
            'quantity' => $this->quantity,
            'total' => $this->total,
        ];
    }
}
