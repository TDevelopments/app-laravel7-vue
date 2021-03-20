<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        return[
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'ruc' => $this->ruc,
            'dni' => $this->dni,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'city' => $this->city,
            'roles' => $this->roles
        ];
    }
}
