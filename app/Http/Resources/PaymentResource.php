<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
          'paymentConcept' => $this->paymentConcept->name,
          'bankEntity' => $this->bankEntity->name
      ];
    }
}
