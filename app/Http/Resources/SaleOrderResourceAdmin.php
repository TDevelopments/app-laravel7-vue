<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleOrderResourceAdmin extends JsonResource
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
            'OrderId' => $this->id,
            'OrderDate' => $this->OrderDate,
            'ShipDate' => $this->ShipDate,
            'SalesTax' => $this->SalesTax,
            'Customer' => $this->SaleCustomer,
            'StateOrder' => $this->SaleStateOrder,
            'Payment' => $this->SalePayment,
        ]
    }
}
