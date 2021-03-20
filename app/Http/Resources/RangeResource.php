<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RangeResource extends JsonResource
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
            'min'  => $this->min,
            'max'  => $this->max,
            'price'  => $this->price,
            'productrange' => $this->productRange,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
