<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'Name' => $this->Name,
            'Address' => $this->Address,
            'City' => $this->City,
            'Region' => $this->Region,
            'PostalCode' => $this->PostalCode,
            'Country' => $this->Country,
        ];
    }
}
