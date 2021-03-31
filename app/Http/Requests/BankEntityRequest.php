<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankEntityRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'short_name' => ['string'],
            'account_name' => ['string'],
            'account_soles' => ['string'],
            'account_interbank_soles' => ['string'],
            'account_dollar' => ['string'],
            'account_interbank_dollar' => ['string'],
        ];
    }
}
