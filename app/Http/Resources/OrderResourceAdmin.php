<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailResource;

class OrderResourceAdmin extends JsonResource
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
            'catalogue' => $this->catalogue,
            'user' => $this->user,
            // 'status' => $this->status,
            'state_order' => $this->stateOrder->id,
            'orderDetails' => OrderDetailResource::collection($this->orderDetails),
            'total_order' => $this->orderDetails->sum('total'),
            'payment' => $this->payments,
        ];
    }
}
