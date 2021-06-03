<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalePaymentRequest extends FormRequest
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
            'TotalPaid' => ['required', 'numeric'],
            'SellNote' => ['required'],
            'PaymentMethodId' => ['required', 'integer', 'exists:App\Models\SalePaymentMethod,id'],
            'PaymentStatusId' => ['required', 'integer', 'exists:App\Models\SalePaymentStatus,id'],
        ];
    }
}
