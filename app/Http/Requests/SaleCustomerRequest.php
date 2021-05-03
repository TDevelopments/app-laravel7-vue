<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleCustomerRequest extends FormRequest
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
            'FirstName' => ['required', 'string'],
            'LastName' => ['required', 'string'],
            'Address1' => ['string'],
            'Address2' => ['string'],
            'City' => ['string'],
            'State' => ['string'],
            'PostalCode' => ['string'],
            'Country' => ['string'],
            'Phone' => ['required', 'string'],
            'Email' => ['string', 'Email'],
            'ShipAddress' => ['string'],
            'ShipCity' => ['string'],
            'ShipRegion' => ['string'],
            'ShipPostalCode' => ['string'],
            'ShipCountry' => ['string'],
            'BillingAddress' => ['string'],
            'BillingCity' => ['string'],
            'BillingRegion' => ['string'],
            'BillingPostalCode' => ['string'],
            'BillingCountry' => ['string'],
            'user_id' => ['integer', 'exists:App\Models\User,id'],
        ];
    }
}
