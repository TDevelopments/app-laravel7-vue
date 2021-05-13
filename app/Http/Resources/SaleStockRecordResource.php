<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleStockRecordResource extends JsonResource
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
            'OrderDetailId' => $this->order_detail_id,
            'Product' => $this->SaleProduct,
            'Quantity' => $this->Quantity,
            'ProductStatus' => $this->SaleProductStatus,
            'BusinessLocation' => $this->SaleBusinessLocation,
            'Customer' => $this->SaleCustomer,
        ];
    }
}
