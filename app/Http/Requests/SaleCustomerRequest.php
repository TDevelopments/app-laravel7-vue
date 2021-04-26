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
            'Address1' => ['required', 'string'],
            'Address2' => ['string'],
            'City' => ['required', 'string'],
            'State' => ['required', 'string'],
            'PostalCode' => ['required', 'string'],
            'Country' => ['required', 'string'],
            'Phone' => ['required', 'string'],
            'Email' => ['required', 'string', 'Email'],
            'ShipAddress' => ['required', 'string'],
            'ShipCity' => ['required', 'string'],
            'ShipRegion' => ['required', 'string'],
            'ShipPostalCode' => ['required', 'string'],
            'ShipCountry' => ['required', 'string'],
            'BillingAddress' => ['required', 'string'],
            'BillingCity' => ['required', 'string'],
            'BillingRegion' => ['required', 'string'],
            'BillingPostalCode' => ['required', 'string'],
            'BillingCountry' => ['required', 'string'],
        ];
    }
}
