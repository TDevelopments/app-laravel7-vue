<?php

namespace App\Http\Resources;
use App\Http\Resources\ArrivalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogueResource extends JsonResource
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
            'quota_date' => $this->quota_date,
            'quota_price' => $this->quota_price,
            'minimum_investment' => $this->minimum_investment,
            'first_payment' => $this->first_payment,
            'date_first_payment' => $this->date_first_payment,
            'second_payment' => $this->second_payment,
            'date_second_payment' => $this->date_second_payment,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'arrivals' => $this->arrivals,
        ];
    }
}
