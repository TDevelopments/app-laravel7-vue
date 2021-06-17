<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'action' => $this->action,
            'model_type' => $this->model_type,
            'model_id' => $this->model_id,
            'user' => $this->user,
            'creation_date' => $this->creation_date,
        ];
    }
}
