<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResourceAdmin extends JsonResource
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
            'image' => $this->image,
            'mount' => $this->mount,
            'payment_date' => $this->payment_date,
            'payment_concept_id' => $this->payment_concept_id,
            'payment_concept_name' => $this->paymentConcept->name,
            'bank_entity_id' => $this->bank_entity_id,
            'nro_operation' => $this->nro_operation,
            'dollar_price' => $this->dollar_price,
            'type_coin' => $this->type_coin,
            'user' => $this->user,
        ];
    }
}
