<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleOrderRequest extends FormRequest
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
            'Products' => ['required', 'array'],
            'Products.*.ProductId' => ['required', 'integer', 'exists:App\Models\SaleProduct,id'],
            'Products.*.Quantity' => ['required', 'integer'],
            'Payment' => ['array'],
            'Payment.TotalPaid' => ['required', 'numeric'],
            'Payment.SellNote' => ['required'],
            'Payment.PaymentMethodId' => ['required', 'integer', 'exists:App\Models\SalePaymentMethod,id'],
            'Payment.PaymentStatusId' => ['required', 'integer', 'exists:App\Models\SalePaymentStatus,id'],
        ];
    }
}
