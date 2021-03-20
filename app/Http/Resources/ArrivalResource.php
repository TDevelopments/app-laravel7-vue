<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArrivalResource extends JsonResource
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
            'city' => $this->city,
            'arrival_date' => (string) $this->arrival_date,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'catalogue' => $this->catalogue,
        ];
    }
}
