<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'catalogue_id' => ['required','exists:App\Models\Catalogue,id'],
            'products' => ['array'],
            'products.*.product_id' => ['required', 'integer', 'exists:'],
            'products.*.quantity' => ['required', 'integer'],
            'product_ranges' => ['array'],
            'product_ranges.*.product_id' => ['required', 'integer', 'exists:App\Models\ProductRange,id'],
            'product_ranges.*.quantity' => ['required', 'integer'],
            'status' => ['in:pending,paid,cancelled,separated,first_payment'],
            
    }
}
