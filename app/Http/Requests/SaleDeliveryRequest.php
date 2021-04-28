<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleDeliveryRequest extends FormRequest
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
            'sale_customer_id' => ['required', 'integer', 'exists:App\Models\SaleCustomer,id'],
            'sale_product_id' => ['required', 'integer', 'exists:App\Models\SaleProduct,id'],
            'Quantity' => ['required', 'integer'],
        ];
    }
}