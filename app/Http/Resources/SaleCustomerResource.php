<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleCustomerResource extends JsonResource
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
            'FullName' => $this->FullName,
            'Address1' => $this->Address1,
            'Address2' => $this->Address2,
            'City' => $this->City,
            'State' => $this->State,
            'PostalCode' => $this->PostalCode,
            'Country' => $this->Country,
            'Phone' => $this->Phone,
            'Email' => $this->Email,
            'ShipAddress' => $this->ShipAddress,
            'ShipCity' => $this->ShipCity,
            'ShipRegion' => $this->ShipRegion,
            'ShipPostalCode' => $this->ShipPostalCode,
            'ShipCountry' => $this->ShipCountry,
            'BillingAddress' => $this->BillingAddress,
            'BillingCity' => $this->BillingCity,
            'BillingRegion' => $this->BillingRegion,
            'BillingPostalCode' => $this->BillingPostalCode,
            'BillingCountry' => $this->BillingCountry,
            'UserId' => $this->User,
        ];
    }
}
