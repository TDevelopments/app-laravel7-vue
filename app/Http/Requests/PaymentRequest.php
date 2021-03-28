<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'mount' => ['required', 'numeric'],
            'payment_date' => ['required', 'date'],
            'image' => ['required'],
            'image.id' => ['required', 'integer', 'exists:App\Models\Image,id'],
            'image.name' => ['required', 'exists:App\Models\Image,name'],
            'image.path' => ['required', 'exists:App\Models\Image,path'],
            'payment_concept_id' => ['required', 'integer', 'exists:App\Models\PaymentConcept,id'],
            'bank_entity_id' => ['required', 'integer', 'exists:App\Models\BankEntity,id'],
        ];
    }
}
