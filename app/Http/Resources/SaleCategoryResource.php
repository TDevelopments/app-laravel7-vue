<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleCategoryResource extends JsonResource
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
            'CategoryId' => $this->id,
            'CategoryName' => $this->CategoryName,
            'CategoryDescription' => $this->CategoryDescription,
            'Active' => $this->Active,
            'Picture' => $this->SalePictures,
        ];
    }
}
