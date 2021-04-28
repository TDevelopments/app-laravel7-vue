<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleDeliveryResource extends JsonResource
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
            'Id' => $this->id,
            'Customer' => $this->SaleCustomer,
            'Product' => $this->SaleProduct,
            'User' => $this->User,
            'Quantity' => $this->Quantity,
        ];
    }
}