<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankEntityResource extends JsonResource
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
            'name' => $this->name,
            'short_name' => $this->short_name,
            'account_name' => $this->account_name,
            'account_soles' => $this->account_soles,
            'account_interbank_soles' => $this->account_interbank_soles,
            'account_dollar' => $this->account_dollar,
            'account_interbank_dollar' => $this->account_interbank_dollar,
        ];
    }
}
