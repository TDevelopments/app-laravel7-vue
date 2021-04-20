<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\PaymentResource;

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
            // 'status' => $this->status,
            'state_order' => $this->stateOrder,
            'shipping_status' => $this->orderShippingStatus,
            'orderDetails' => OrderDetailResource::collection($this->orderDetails),
            'total_order' => $this->orderDetails->sum('total'),
            'payment' => PaymentResource::collection($this->payments),
        ];
    }
}
