<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailResource;

class OrderResource extends JsonResource
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
            'catalogue' => $this->catalogue,
            'user' => $this->user,
            'status' => $this->status,
            'orderDetails' => $this->orderDetails,
            'total_order' => $this->orderDetails->sum('total'),
            'payment' => $this->payments,
        ];
    }
}
