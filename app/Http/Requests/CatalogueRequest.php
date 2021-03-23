<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'image.id' => ['required', 'exists:App\Models\Image,id'],
            'image.name' => ['required', 'exists:App\Models\Image,name'],
            'image.path' => ['required', 'exists:App\Models\Image,path'],
            'conditions' => ['array'],
            'conditions.*' => ['string'],
            'is_available' => ['boolean'],
            'coin' => ['required', 'in:soles,dolares'],
            'quota_date' => ['required'],
            'quota_price' => ['required'],
            'minimum_investment' => ['required'],
            'first_payment' => ['required'],
            'date_first_payment' => ['required', 'date'],
            'second_payment' => ['required'],
            'date_second_payment' => ['required', 'date'],
        ];
    }
}
